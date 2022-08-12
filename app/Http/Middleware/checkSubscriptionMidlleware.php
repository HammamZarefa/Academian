<?php

namespace App\Http\Middleware;

use App\Subscription;
use Closure;

class checkSubscriptionMidlleware
{
    public $subscription;
    public function __construct(Subscription $subscription)
    {
        $this->subscription=$subscription;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$online_service_id)
    {
        $user = auth()->user();
        $user_sub=$this->subscription->where('user_id',$user->id)->where('online_service_id',$online_service_id)->first();
        if (is_null($user_sub) || $user_sub->activity === false ){
            return redirect('subscripe/'.$online_service_id);
        }else {
            return $next($request);
        }
    }
}
