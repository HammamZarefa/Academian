<?php

namespace App\PaymentGateways\two_checkout;

use Illuminate\Http\Request;
use App\PaymentGateways\two_checkout\lib\Twocheckout;
use App\Http\Controllers\Payments\PaymentGatewayController;
use App\PaymentGateways\two_checkout\lib\Twocheckout\Twocheckout_Charge;
use App\PaymentGateways\two_checkout\lib\Twocheckout\Api\Twocheckout_Error;

class TwoCheckoutController extends PaymentGatewayController
{
    public function __construct()
    {
        parent::__construct('two_checkout');

        //Stripe::setApiKey($this->gateway->keys->secret_key);
    }

    public function index(Request $request)
    {
        $error = null;

        try {
            $data['total'] = $this->cart->getTotal();
            $data['gateway_name'] = $this->gateway->name;
            $data['merchant_code'] = $this->gateway->keys->merchant_code;
            $data['customer_name'] = auth()->user()->full_name;
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
       // pr([$this->gateway->keys->secret_key, $this->gateway->keys->merchant_code]);
        Twocheckout::privateKey($this->gateway->keys->private_key); //Private Key
        Twocheckout::sellerId($this->gateway->keys->merchant_code); // 2Checkout Account Number
        //Twocheckout::sandbox(true); // Set to false for production accounts.

        Twocheckout::verifySSL(false);  // this is set to true by default

        try {
            $charge = Twocheckout_Charge::auth(array(
                // "merchantOrderId" => "123",
                // "token"      => $request->token,
                // "currency"   => 'USD',
                // "total"      => $this->cart->getTotal(),
                // "billingAddr" => array(
                //     "name" => 'Testing Tester',
                //     "addrLine1" => '123 Test St',
                //     "city" => 'Columbus',
                //     "state" => 'OH',
                //     "zipCode" => '43123',
                //     "country" => 'USA',
                //     "email" => 'example@2co.com',
                //     "phoneNumber" => '555-555-5555'
                // )

                "sellerId" => $this->gateway->keys->merchant_code,
        "merchantOrderId" => "123",
        "token" => $request->token,
        "currency" => 'USD',
        "total" => $this->cart->getTotal(),
        "billingAddr" => array(
            "name" => auth()->user()->full_name,
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        )

            ));

            if ($charge['response']['responseCode'] == 'APPROVED') {
                echo "Thanks for your Order!";
                echo "<h3>Return Parameters:</h3>";
                echo "<pre>";
                print_r($charge);
                echo "</pre>";
            }
        } catch (Twocheckout_Error $e) {
            print_r($e->getMessage());
        }
    }
    // public function capturePayment2(Request $request)
    // {
    //     $intent = null;
    //     try {
    //         if (isset($request->payment_method_id)) {
    //             # Create the PaymentIntent
    //             $intent = PaymentIntent::create([
    //                 'payment_method' => $request->payment_method_id,
    //                 'amount' => $this->convertToCent($this->cart->getTotal()),
    //                 'currency' => strtolower($this->cart->getCurrency()),
    //                 'confirmation_method' => 'manual',
    //                 'confirm' => true,
    //             ]);
    //         }
    //         if (isset($request->payment_intent_id)) {
    //             $intent = PaymentIntent::retrieve(
    //                 $request->payment_intent_id
    //             );
    //             $intent->confirm();
    //         }
    //         $res = $this->generateResponse($intent);
    //     } catch (\Stripe\Exception\ApiErrorException $e) {
    //         # Display error on client
    //         $res = [
    //             'error' => $e->getMessage(),
    //         ];
    //     }

    //     return response()->json($res);
    // }

    // public function generateResponse($intent)
    // {
    //     # Note that if your API version is before 2019-02-11, 'requires_action'
    //     # appears as 'requires_source_action'.
    //     if (($intent->status == 'requires_action' || $intent->status == 'requires_source_action') &&
    //         $intent->next_action->type == 'use_stripe_sdk'
    //     ) {
    //         # Tell the client side to handle the action
    //         return [
    //             'requires_action' => true,
    //             'payment_intent_client_secret' => $intent->client_secret,
    //         ];
    //     } else if ($intent->status == 'succeeded') {
    //         # The payment didn’t need any additional actions and completed!
    //         # Handle post-payment fulfillment
    //         $token = $this->savePaymentRecords($this->cart->getTotal(), $intent->id);
    //         return [
    //             "success" => true,
    //             'redirect_url' => $this->urltoRedirectOnSuccess($token)
    //         ];
    //     } else {
    //         # Invalid status
    //         return ['error' => 'Could not process your payment'];
    //     }
    // }

    // private function convertToCent($amount)
    // {
    //     // Stripe accepts the amount as cents only.
    //     return intval($amount * 100);
    // }
}
