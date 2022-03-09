<?php

namespace App\PaymentGateways\braintree;

use App\Http\Controllers\Payments\PaymentGatewayController;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BraintreeController extends PaymentGatewayController
{

    private $client;

    public function __construct()
    {
        parent::__construct('braintree');

        $this->client = new Gateway($this->environment());
    }

    public function index(Request $request)
    {
        $error = null;

        try {
            $data['total'] = $this->cart->getTotal();
            $data['gateway_name'] = $this->gateway->name;
            $data['client_token'] = $this->client->ClientToken()->generate();
            $data['enable_paypal'] = false;
            if(isset($this->gateway->keys->is_paypal_enabled))
            {
                $data['enable_paypal'] = $this->gateway->keys->is_paypal_enabled;
            }   
            return view($this->getPaymentView(), compact('data'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While generating token');
        }

        return $this->redirectOnFailedTokenGeneration();
    }

    public function capturePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_nonce' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $error = null;

        try {
            $result = $this->client->transaction()->sale([
                'amount' => $this->cart->getTotal(),
                'paymentMethodNonce' => $request->payment_method_nonce,
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]);

            if (isset($result->success) && $result->success) {

                // Record the Payment Information
                $token = $this->savePaymentRecords($result->transaction->amount, $result->transaction->id);

                return $this->redirectOnSuccess($token);
            } else {
                $error = $result->message;
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While capturing payment');
        }

        return $this->redirectOnFail();
    }

    private function environment()
    {
        return [
            'environment' => ($this->gateway->keys->environment == 'production') ? 'production' : 'sandbox',
            'merchantId' => $this->gateway->keys->merchant_id,
            'publicKey' => $this->gateway->keys->public_key,
            'privateKey' => $this->gateway->keys->private_key,
        ];
    }
}
