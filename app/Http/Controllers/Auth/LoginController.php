<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if user is inactive
        $user = User::where('email',$request->email)->first();
        if($user && $user->inactive)
        {
            throw ValidationException::withMessages([
                $this->username() => __('The account in suspended')]);
        }

        // Then, validate input.
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    protected function authenticated(Request $request, $user) 
    {
        $intended_url = redirect()->intended()->getTargetUrl();

        if($intended_url == route('order_page'))
        {
            return redirect()->route('order_page');
        }       

        return redirect()->route(get_default_route_by_user($user));
        
    }

    protected function loggedOut(Request $request) {
        return redirect()->route('login');
    }

}
