<?php

namespace App\Services;

use App\User;
use App\UserRecord;
use Illuminate\Support\Arr;

class UserService
{

    public function create($request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->save();

        $user->assignRole(Arr::wrap($request->role));
        $this->save_user_records($request, $user);

        return $user;
    }

    public function update($request, $id)
    {
        $user = User::find($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->timezone = $request->timezone;
        $user->inactive = (isset($request->inactive)) ? TRUE : NULL;

        $user->save();
        $user->syncRoles(Arr::wrap($request->role_id));
        $this->save_user_records($request, $user);

        if ($user->hasRole('staff')) {
            // Attaching Tags
            $user->tag_sync($request->tag_id);
        }
    }

    public function update_self_profile($request, User $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->timezone = $request->timezone;
        $user->save();

        $this->save_user_records($request, $user);

        if ($user->hasRole('staff')) {
            // Attaching Tags
            $user->tag_sync($request->tag_id);
        }
    }

    public function saveResume($file, User $user)
    {
        $rec = UserRecord::firstOrNew([
            'user_id' => $user->id,
            'option_key' => 'resume'
        ]);
        $rec->option_value = $file;
        $rec->save();
    }

    private function save_user_records($request, $user)
    {
        if ($user->hasRole('staff')) {
            $keys = [
                'preferred_payment_method',
                'payment_method_details',
                'bio',
                'address',
                'country',
                'referral_source',                
            ];
        } else {
            $keys = [
                'bio',
                'country',
                'referral_source',
            ];
        }

        if (count($keys) > 0) {
            foreach ($keys as $key) {
                $rec = UserRecord::firstOrNew([
                    'user_id' => $user->id,
                    'option_key' => $key
                ]);

                $rec->option_value = $request->{$key};
                $rec->save();
            }
        }
    }
}
