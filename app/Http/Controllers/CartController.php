<?php

namespace App\Http\Controllers;

use App\Order;
use App\Enums\CartType;
use App\Services\CartService;
use App\Services\CalculatorService;
use Mews\Purifier\Facades\Purifier;
use App\Http\Requests\StoreOrderRequest;

class CartController extends Controller
{
    public function storeOrderInSession(StoreOrderRequest $request, CalculatorService $calculator, CartService $cart)
    {
        $data = $request->validated();
        $data = array_merge($data, $calculator->calculatePrice($data));
        $data['customer_id'] = auth()->user()->id;
        $data['cart_total'] = $data['total'];
        $data['staff_payment_amount'] = $calculator->staffPaymentAmount($data['cart_total']);
        $data['title'] = Purifier::clean($request->input('title'));
        $data['instruction'] = Purifier::clean($request->input('instruction'));

        $orderService = app()->make('App\Services\OrderService');
        $order = $orderService->create($data);

        $cart->setCart([
            'order_id' => $order->id,
            'order_number' => $order->number,
            'cart_total' => $data['cart_total']
        ], CartType::NewOrder);

        session()->flash('success', 'Order has been saved. Please make the payment to confirm it'); 

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('choose_payment_method')
        ]);
    }

    public function makePaymentForExistingOrder(Order $order, CartService $cart)
    {
        if ($order->customer_id = auth()->user()->id) {

            $cart->setCart([
                'order_id' => $order->id,
                'order_number' => $order->number,
                'cart_total' => $order->total
            ], CartType::NewOrder);

            return redirect()->route('choose_payment_method');
        }

        
    }
}
