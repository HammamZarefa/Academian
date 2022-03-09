<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\CartService;

class CheckCart
{
    private $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->cart->isEmpty())
        {         
            return redirect()->route(get_default_route_by_user(auth()->user()));
        }  

        return $next($request);
    }
}
