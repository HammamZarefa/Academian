<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\OnlineService;
use App\Services\CartService;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public $cart;
    public function __construct(CartService $cart)
    {
        $this->cart=$cart;
    }

    public function selectSubscripe($id)
    {
        $user_id=auth()->user()->id;
        $online_service=OnlineService::find($id);
//        $online_service_id=$id;
//        return OnlineService::get();
        return view('subscripe.select_supscripe',compact(['online_service','user_id']));
    }

    public function subscripe(Request $request ,$cart){
        return $request;
//                return OnlineService::get();
//        $cart->setCart([
//            'order_id' => $order->id,
//            'order_number' => $order->number,
//            'cart_total' => $order->total
//        ], CartType::NewOrder);

        return redirect()->route('choose_payment_method');


    }

}
