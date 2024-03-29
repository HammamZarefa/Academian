<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\OnlineService;
use App\Services\CartService;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class SubscriptionsController extends Controller
{
    public $cart;
    public $subscription;
    public function __construct(CartController $cart,Subscription $subscription)
    {
        $this->cart=$cart;
        $this->subscription=$subscription;
    }

    public function selectSubscripe($id)
    {
        $user_id=auth()->user()->id;
        $online_service=OnlineService::find($id);
//        $online_service_id=$id;
//        return OnlineService::get();
        return view('subscripe.select_supscripe',compact(['online_service','user_id']));
    }

    public function subscripe($id){
        try {
            $service=OnlineService::find($id);
            $data['customer_id'] =  auth()->user()->id;
            $data['cart_total'] =   $service->price;
            $data['service_id']=    70;
            $data['work_level_id']= 6;
            $data['urgency_id']=    22;
            $data['unit_name']=     'fixed';
            $data['base_price']=    $data['cart_total'];
            $data['work_level_price']=0;
            $data['urgency_price']= 0;
            $data['unit_price']=    $data['cart_total'];
            $data['amount']=1;
            $data['dead_line']=     now();
            $data['online_service_id']=     $id;
            $order=$this->cart->storeSubscriptionInSession($data);

            return redirect()->route('choose_payment_method');

        }catch (\Exception $exception){
            return $exception->getMessage();
        }



    }

    public function NewSupEvent(){

    }

}
