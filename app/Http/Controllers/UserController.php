<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use Carbon\Carbon;
use App\Mail\InviteUser;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Services\AvatarUploadService;
use App\Notifications\NewRoleAssigned;
use App\Http\Requests\UpdateUserRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Junaidnasir\Larainvite\Facades\Invite;
use App\Http\Requests\ChangeProfilePhotoRequest;
use Junaidnasir\Larainvite\Models\LaraInviteModel as UserInvitation;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function restrict_user_types($type)
    {
        if (!in_array($type, [
            'admin',
            'customer',
            'staff'
        ])) {
            abort(404);
        }
    }

    public function index(Request $request)
    {
        $this->restrict_user_types($request->type);

        $data['type'] = $request->type;

        if ($request->type == 'staff') {
            $data['entity'] = 'Writers';
            $data['entity_singular'] = 'Writer';
            $data['tag_id_list'] = Tag::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        } else if ($request->type == 'admin') {
            $data['entity'] = 'Admins';
            $data['entity_singular'] = 'Admin';
        } else {
            $data['entity'] = 'Customers';
            $data['entity_singular'] = 'Customer';
        }

        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $this->restrict_user_types($request->type);

        if ($request->type == 'customer') {
            $users = User::doesntHave('roles');
        } else if ($request->type == 'admin') {
            $users = User::role('admin');
        } else {
            $users = User::role('staff');
        }

        if ($request->inactive) {
            $users->where('inactive', 1);
        } else {
            $users->whereNull('inactive');
        }

        $users->orderBy('first_name', 'ASC');

        return Datatables::eloquent($users)->addColumn('user_html', function ($user) {
            return view('user.partials.user_list_row', compact('user'))->render();
        })
            ->rawColumns([
                'user_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->search) {
                    // Split the terms by word.
                    $terms = explode(" ", $request->search);
                    foreach ($terms as $term) {
                        // Loop over the terms and do a search for each.
                        $query->where('first_name', 'like', '%' . $term . '%')
                            ->orWhere('last_name', 'like', '%' . $term . '%')
                            ->orWhere('email', 'like', '%' . $term . '%');
                    }

                    $query->orderByRaw("(first_name = '{$request->search}') desc, length(first_name)");
                }

                if ($request->tags) {
                    $query->whereHas('tags', function ($q) use ($request) {
                        $q->whereIn('tags.id', $request->tags);
                    });
                }
            })
            ->make(true);
    }

    public function show(User $user)
    {
        $user->setMetaData();

        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->setMetaData();

        $data = User::adminDropdown();

        $roles = $user->getRoleNames()->toArray();

        $data['attached_roles'] = array_combine($roles, $roles);

        return view('user.show', compact('user', 'data'));
    }

    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        $userService->update($request, $user->id);
        // Log user's activity
        $subject = anchor($user->full_name, route('user_profile', $user->id));
        logActivity($user, 'updated profile of ' . $subject);

        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function change_photo(ChangeProfilePhotoRequest $request, User $user, AvatarUploadService $avatar)
    {
        // Log user's activity
        $subject = anchor($user->full_name, route('user_profile', $user->id));
        logActivity($user, 'updated avatar of ' . $subject);

        return response()->json($avatar->upload($request, $user));
    }

    public function invitation(Request $request)
    {
        if (!in_array($request->type, [
            'admin',
            'staff'
        ])) {
            abort(404);
        }

        $data['type'] = $request->type;

        return view('user.invitation', compact('data'));
    }

    public function send_invitation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role_type' => 'required|in:admin,staff'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role_name = ($request->role_type == 'admin') ? 'Admin' : 'Writer';

        $users = User::where('email', $request->email)->get();

        if ($users->count() > 0) {
            $user = $users->first();

            // User already exists
            if ($user->hasRole($request->role_type)) {
                // Already an author
                return redirect()->back()->withErrors(new MessageBag([
                    'email' => 'The email is already registed in the system'
                ]));
            } else {
                // Assign the role
                $user->assignRole($request->role_type);

                // Notify the user regarding the new role
                $user->notify(new NewRoleAssigned($role_name));

                $message = 'The email already exists and the role has been assigned to the user.';
            }
        } else {
            // User does not exist, so we need to send the invitation

            // Before that check if it is already in the UserInvitation table
            $invitations = UserInvitation::where('email', $request->email)->get();

            if ($invitations->count() > 0) {
                // Delete the old invitation
                $invitations->first()->delete();
            }

            // Send Invitation
            $token = Invite::invite($request->email, auth()->user()->id, Carbon::now()->addDays(2), function ($invitation) use ($request) {
                $invitation->role_name = $request->role_type;
            });

            Mail::to($request->email)->send(new InviteUser($token, $role_name));

            $message = 'Invitation sent to the user';

            // Log user's activity          
            logActivity(auth()->user(), 'sent invitation at ' . $request->email);
        }

        return redirect()->back()->withSuccess($message);
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->hasRole('admin')) {
            $type = 'admin';
        } elseif ($user->hasRole('staff')) {
            $type = 'staff';
        } else {
            $type = 'customer';
        }

        $redirect = redirect()->route('users_list', ['type' => $type]);

        DB::beginTransaction();

        try {

            $user->delete();
            // Log user's activity          
            logActivity($user, 'deleted user ' . $user->full_name);
            $redirect->withSuccess('Successfully deleted');
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            $redirect->withFail('You cannot delete the user as he/she is associated with one or multiple entities');
            DB::rollback();
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
            DB::rollback();
        }

        return $redirect;
    }

    public function ratings(User $user)
    {
        $user->setMetaData();

        $data['tag_id_list'] = Tag::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        $data['role_id_list'] = Role::orderBy('name', 'ASC')->pluck('name', 'name')->toArray();

        $roles = $user->getRoleNames()->toArray();

        $data['attached_roles'] = array_combine($roles, $roles);

        return view('user.show', compact('user', 'data'));
    }
}
