<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\PaymentGateway;
use Illuminate\Support\Facades\Log;
class PaymentGatewayController extends Controller
{

    protected $cart;

    protected $gateway;

    protected $gatewayUniqueName;

    public function __construct($gatewayUniqueName)
    {
        $this->gatewayUniqueName = $gatewayUniqueName;
        $this->gateway = PaymentGateway::getByUniqueName($gatewayUniqueName);

        if (empty($this->gateway)) {
            abort(401, 'Invalid Payment Processor');
        }

        $this->cart = app()->make('App\Services\CartService');
    }

    protected function logError($error, $when)
    {
        Log::debug('payment_gateway_error', [
            'user_id' => auth()->user()->id,
            'gateway' => $this->gateway->unique_name,
            'when'  => $when,
            'message' => $error
        ]);
     
    }

    protected function getPaymentView()
    {
        return $this->gatewayUniqueName .'.views.checkout';
    }

    protected function redirectOnFailedTokenGeneration()
    {
        return redirect()->route('choose_payment_method')->withFail('Please try a different payment option');
    }

    protected function redirectOnSuccess($payment_unique_identifier)
    {
        return redirect()->route('handle_succesfull_online_payment', ['token' => $payment_unique_identifier]);
    }

    protected function urltoRedirectOnSuccess($payment_unique_identifier)
    {
        return route('handle_succesfull_online_payment', ['token' => $payment_unique_identifier]);
    }

    protected function redirectOnFail()
    {
        return redirect()->route('choose_payment_method')->withFail('Could not process your payment. Please try again');
    }

    /**
     * Record payment details.
     *
     * @param  float $amount
     * @param  string  $transactionReference
     * @return string
     */
    protected function savePaymentRecords($amount, $transactionReference)
    {
        $paymentRecordService = app()->make('App\Services\PaymentRecordService');

        // Record the Payment Information        
        $paymentRecordService->store(auth()->user()->id , $this->gateway->name, $amount, $transactionReference);

        // Mark in the cart that payment has been made
        $payment_unique_identifier = bin2hex(random_bytes(5));
        $this->cart->setPaymentComplete($amount, $payment_unique_identifier);

        return $payment_unique_identifier;
    }
}
