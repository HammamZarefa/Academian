<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Junaidnasir\Larainvite\Facades\Invite;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $data = [];

        if(isset($request->c))
        {
            $token = $request->c;

            if(!Invite::isValid($token))
            {
                abort(404);        
            } 
            
            $invitation = Invite::get($token); 
            
            $request->session()->put('email', $invitation->email);
            $data['user_token'] = $request->c;
            $data['user_role']  = ($invitation->role_name == 'admin') ? 'as an admin' : 'as a writer';
        }

        return view('auth.register', compact('data'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:1', 'confirmed'],
        ];

        if(isset($data['user_token']) && (!empty($data['user_token'])) )
        {
            $token = $data['user_token'];

            if(Invite::isValid($token))
            {
                $invitation = Invite::get($token); 
                array_push($rules['email'], 'in:'. $invitation->email);            
            }
            else
            {
                abort(404);
            }   
            
        }

        $messages = [
            'email.in' => 'No invitation was not sent to this email'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    protected function create(array $data)
    {        
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);

        if(isset($data['user_token']))
        {
            $invitation = Invite::get($data['user_token']);

            // Assign the role
            $user->assignRole($invitation->role_name);
            
            // Delete the invitation            
            $invitation->delete();
        }
        else
        {
            $user->sendEmailVerificationNotification();
        }
        //$this->redirectTo = '/url-after-register';
        return $user;
    }

    
   
}