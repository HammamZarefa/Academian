<?php

namespace App\PaymentGateways\payu;

use App\Http\Controllers\Payments\PaymentGatewayController;
use Illuminate\Http\Request;


class PayUController extends PaymentGatewayController
{
    public function __construct()
    {
        parent::__construct('payu');        
    
    }

    public function index(Request $request)
    {
        $rec = new \stdClass();

        $rec->key = $this->gateway->keys->merchant_key;
        $rec->salt = $this->gateway->keys->merchant_salt;        
        $rec->amount = $this->cart->getTotal();        
        $rec->fname = auth()->user()->first_name;
        $rec->email = auth()->user()->email;
        $rec->txnid = rand(10000,99999999);
        $rec->pinfo = 'service';
        $rec->udf5 = 'BOLT_KIT_PHP7';
        $rec->phone = "23423";
        $rec->surl = route('payu_payment_captured');
        $rec->furl = route('payu_payment_captured');
        
      
        $error = null;

        try {
            $data['rec'] = $rec;
            $data['hash'] = $this->generateHash($rec);
            $data['total'] = $this->cart->getTotal();
            $data['gateway_name'] = $this->gateway->name;
            $data['environment'] = $this->gateway->keys->environment;
     
            return view($this->getPaymentView(), compact('data'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While generating hash');
        }

        return $this->redirectOnFailedTokenGeneration();
    }

    public function paymentCaptured(Request $request)
    {
        //https://stackoverflow.com/questions/62276196/payumoney-test-card-details
        $postdata = $request->all();

        if (isset($postdata['key']) && isset($postdata['payuMoneyId'])) {
            $key				=   $postdata['key'];
            $salt				=   $this->gateway->keys->merchant_salt;
            $txnid 				= 	$postdata['txnid'];
            $amount      		= 	$postdata['amount'];
            $productInfo  		= 	$postdata['productinfo'];
            $firstname    		= 	$postdata['firstname'];
            $email        		=	$postdata['email'];
            $udf5				=   $postdata['udf5'];
            // $mihpayid			=	$postdata['mihpayid'];
            $status				= 	$postdata['status'];
            $resphash				= 	$postdata['hash'];
            //Calculate response hash to verify
            $keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
            $keyArray 	  		= 	explode("|", $keyString);
            $reverseKeyArray 	= 	array_reverse($keyArray);
            $reverseKeyString	=	implode("|", $reverseKeyArray);
            $CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));
            
            
            if ($status == 'success'  && $resphash == $CalcHashString) {
                // Record the Payment Information
                $token = $this->savePaymentRecords($postdata['amount'], $postdata['payuMoneyId']);
                return $this->redirectOnSuccess($token);
                
            
            } else {
                //tampered or failed
               return $this->redirectOnFail();
            }           
           
        }
        else
        {
            return $this->redirectOnFail();
        }
    }

    public function generateHash($data)
    {
        return hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
    }

    
}
