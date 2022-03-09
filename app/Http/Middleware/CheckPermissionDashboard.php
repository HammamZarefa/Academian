<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermissionDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if($user->hasRole('admin'))
        {
             return $next($request);
        }
        else
        {
            if($user->hasRole('staff'))
            {
                return redirect()->route(get_default_route_by_user(auth()->user()));
            }

            $intended_url = redirect()->intended()->getTargetUrl();

            if($intended_url == route('order_page'))
            {
                return redirect()->route('order_page');
            }       
            return redirect()->route(get_default_route_by_user(auth()->user()));
        }

       
    }
}
