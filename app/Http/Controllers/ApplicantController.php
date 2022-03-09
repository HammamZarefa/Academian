<?php

namespace App\Http\Controllers;

use App\User;
use App\Applicant;
use App\ApplicantStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Mail\ApplicationApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Applicant::adminSearchDropdown();
        return view('applicant.index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $applicants = Applicant::with(['status', 'referral_source'])->orderBy('first_name', 'ASC');

        return Datatables::eloquent($applicants)->addColumn('applicant_html', function ($applicant) {
            return view('applicant.partials.applicant_list_row', compact('applicant'))->render();
        })
            ->rawColumns([
                'applicant_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->general_text_search) {
                    $query->where('number', $request->general_text_search)
                        ->orWhere('first_name', 'like', '%' . $request->general_text_search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->general_text_search . '%')
                        ->orWhere('email', 'like', '%' . $request->general_text_search . '%');
                }
                if ($request->applicant_status_id) {
                    $query->where('applicant_status_id', $request->applicant_status_id);
                }
                if ($request->referral_source_id) {
                    $query->where('referral_source_id', $request->referral_source_id);
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Applicant::applyAsCandidateDropdown();
        return view('applicant.apply', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:applicants',
            'country_id' => 'required',
            'referral_source_id' => 'required',
            'resume' => 'required|mimes:pdf|max:5000',
        ], [
            'email.unique'=> 'Looks like we already have your application'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $request['applicant_status_id'] = 1;
        $request['number'] = mt_rand(100000, 999999);
        $request['attachment'] = $request->file('resume')->store('resumes');

        Applicant::create($request->all());

        $message = settings('writer_application_form_success_message');

        if (empty($message)) {
            $message = 'Thank you for submitting your application.';
        }
        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        $data['statuses'] = ApplicantStatus::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        return view('applicant.profile', compact('data', 'applicant'));
    }

    /**
     * Change the status of the specified resource.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, Applicant $applicant)
    {
        $applicant->applicant_status_id = $request->applicant_status_id;
        $applicant->note = $request->note;
        $applicant->save();
        return redirect()->back()->withSuccess('Status updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        Storage::delete($applicant->attachment);
        $applicant->delete();
        return redirect()->route('job_applicants')->withSuccess('Applicant Deleted');
    }

     /**
     * Hire  applicant and invite to join
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function inviteToJoin(Applicant $applicant, UserService $userService)
    {
        $password = Str::random(10);
        // Check if he is already a user
        $users = User::where('email', $applicant->email)->get();
        if ($users->count() > 0) {
            // if already a user then check the role
            $user = $users->first();
            if ($user->hasRole('admin')) {               
                return redirect()->back()->withFail('The profile is already registerd as an admin');
            }
            elseif (!$user->hasRole('staff')) {
                // Assign the role
                $user->assignRole('staff');
            }
            // Reset the password
            $user->password = $password;
        } else {
            $applicant->bio = $applicant->about;
            $applicant->referral_source = $applicant->referral_source->name;
            $applicant->country = $applicant->country->name;
            $applicant->resume = $applicant->attachment;

            $applicant->role = 'staff';
            $applicant->password = $password;
            $user = $userService->create($applicant);
            // Save Resume/CV
            $userService->saveResume($applicant->attachment, $user);
        }

        Mail::to($user->email)->send(new ApplicationApproved($user, $password));

        return redirect()->route('user_profile', $user->id)->withSuccess('Invitation sent');
    }
}
