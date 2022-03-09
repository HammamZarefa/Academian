<?php

namespace App\PaymentGateways\paystack;

use App\Http\Controllers\Payments\PaymentGatewayController;
use Illuminate\Http\Request;

class PaystackController extends PaymentGatewayController
{
    public function __construct()
    {
        parent::__construct('paystack');
    }

    public function index(Request $request)
    {
        $error = null;

        try {
            $data['total'] = $this->cart->getTotal();
            $data['gateway_name'] = $this->gateway->name;
            $data['public_key'] = $this->gateway->keys->public_key;
            $data['payment_amount'] = $this->convertToCent($this->cart->getTotal());

            $data['email'] = auth()->user()->email; 

            $data['first_name'] = auth()->user()->first_name; 
            $data['last_name'] = auth()->user()->last_name; 

            // Use NGN, GHS for Ghana Cedis or USD for US Dollars
            $data['currency'] = $this->cart->getCurrency();      
            
            return view($this->getPaymentView(), compact('data'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While generating token');
        }

        return $this->redirectOnFailedTokenGeneration();
    }


    public function verifyPayment(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/". $request->reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ". $this->gateway->keys->secret_key,
                "Cache-Control: no-cache",
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $error = curl_error($curl);
        curl_close($curl);

        if(isset($response->status) && ($response->status == true) && (isset($response->data->reference)))
        {
            $token = $this->savePaymentRecords($this->cart->getTotal(), $response->data->reference);
            return [
                "success" => true,
                'redirect_url' => $this->urltoRedirectOnSuccess($token)
            ];
            
        } 
        else {    
            $this->logError($error, 'While verifiying payment - Paystack');        
            return ['error' => true, 'message' => 'Could not process your payment'];
        }
    }

    private function convertToCent($amount)
    {
        // It accepts the amount as cents only.
        return intval($amount * 100);
    }
}
