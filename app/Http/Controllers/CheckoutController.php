<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\Enums\PaymentReason;
use Illuminate\Http\Request;
use App\OfflinePaymentMethod;
use App\Services\CartService;
use App\PendingForApprovalPayment;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentOptionsService;
use App\Http\Requests\ProcessOfflinePaymentRequest;

class CheckoutController extends Controller
{
    private $cart;

    function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function choosePaymentMethod(Request $request, PaymentOptionsService $paymentOptions)
    {
        $data['total'] = $this->cart->getTotal();
        $data['payment_options'] = $paymentOptions->all();
        $data['show_wallet_option'] = true;

        if ($this->cart->getCartType() != CartType::NewOrder) {
            $data['show_wallet_option'] = false;
        } else {
            if (isset($this->cart->getCart()['order_number'])) {
                $order = $this->cart->getCart();
                $data['order_number'] = $order['order_number'];
                $data['order_link'] = route('orders_show', $order['order_id']);
            }
        }

        return view('checkout.select_payment_method')->with('data', $data);
    }


    public function handleSuccessfullOnlinePayment(Request $request)
    {
        if (!$this->isValidToken($request)) {
            abort(400, 'Bad Request');
        }
        // it was an order
        if ($this->cart->getCartType() == CartType::NewOrder) {

            $order_id = $this->cart->getCart()['order_id'];
            $this->confirmOrderPayment($order_id);

            // Destroy the cart
            $this->cart->destroy();

            return redirect()->route('orders_show', $order_id)
                ->withSuccess('Your order has been received. You will be notified when your document is ready');
        } else {
            // It's a top up for wallet

            // Destroy the cart and redirect to success page
            $this->cart->destroy();

            return redirect()->route('my_account', ['group' => 'wallet'])
                ->withSuccess('Your wallet has been topped up successfully');
        }
    }


    public function payUsingOfflineMethod(Request $request, OfflinePaymentMethod $paymentMethod)
    {
        $data['total'] = $this->cart->getTotal();
        $data['gateway_name'] = $paymentMethod->name;
        return view('checkout.offline_payment', compact('data'))->with('paymentMethod', $paymentMethod);
    }

    public function processOfflinePayment(ProcessOfflinePaymentRequest $request, OfflinePaymentMethod $paymentMethod)
    {
        $settings = $paymentMethod->settings;
        $attachment = null;

        if ($settings->requires_uploading_attachment == true) {
            $attachment = $request->file('attachment')->store('payments/attachments');
        }

        DB::beginTransaction();
        $success = false;
        try {

            // it was an order
            if ($this->cart->getCartType() == CartType::NewOrder) {
                $payment_reason = PaymentReason::order;
            } else {
                // It's a top up for wallet
                $payment_reason = PaymentReason::wallettopup;
            }

            PendingForApprovalPayment::create([
                'user_id' => auth()->user()->id,
                'method' => $paymentMethod->name,
                'amount' => $this->cart->getTotal(),
                'reference' => $request->reference,
                'attachment' => $attachment,
                'payment_reason' => $payment_reason,
                'cart' => $this->cart->getCart()
            ]);
            // If it was an order, update the status to "payment needs approval"
            if (isset($this->cart->getCart()['order_id'])) {
                $order_id = $this->cart->getCart()['order_id'];
                $this->getOrderService()->markAsPaymentWaitingForApproval($order_id);
            }

            $success = true;
            DB::commit();
        } catch (\Exception  $e) {
            $success = false;
            DB::rollback();
        }

        if ($success) {
            // the transaction worked ...            
            return redirect()->route('offline_payment_success')
                ->with('success_message', $paymentMethod->success_message);
        } else {

            return redirect()->back()->withFail('Sorry the request was not successful, please try again');
        }
    }

    public function offlinePaymentSuccess(Request $request)
    {
        if (empty(session()->has('success_message'))) {
            return redirect()->route(get_default_route_by_user(auth()->user()));
        }
        // clear the cart
        $this->cart->destroy();

        $data['message'] = session()->get('success_message');
        return view('checkout.complete', compact('data'));
    }


    public function processWalletPayment(Request $request)
    {

        if ($this->cart->getCartType() != CartType::NewOrder) {
            return redirect()->back()->withFail('You can pay using your wallet only for placing orders');
        }
        if (empty($this->cart->getTotal())) {
            return redirect()->back()->withFail('Your cart is empty');
        }
        if ($this->cart->getTotal() > auth()->user()->wallet()->balance()) {
            return redirect()->back()->withFail('You wallet doesn\'t have sufficient balance');
        }

        DB::beginTransaction();
        $success = false;
        try {

            $order_id = $this->cart->getCart()['order_id'];
            $this->confirmOrderPayment($order_id);

            // Destroy the cart
            $this->cart->destroy();
            $success = true;
            DB::commit();
        } catch (\Exception  $e) {
            $success = false;
            DB::rollback();
        }

        if ($success) {
            // the transaction worked ...            
            return redirect()->route('orders_show', $order_id)->withSuccess('Your order has been received. You will be notified when your document is ready');
        } else {

            return redirect()->back()->withFail('Sorry the request was not successful, please try again');
        }
    }

    private function getOrderService()
    {
        return app()->make('App\Services\OrderService');
    }

    private function confirmOrderPayment($order_id)
    {
        return $this->getOrderService()->confirmOrderPayment($order_id);
    }


    private  function isValidToken($request)
    {
        if (isset($request->token) && $request->token) {
            return $this->cart->isPaymentComplete($request->token);
        }
    }
}
