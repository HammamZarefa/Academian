<?php

namespace App\PaymentGateways\Blockchain;

use App\Http\Controllers\Payments\PaymentGatewayController;
use Illuminate\Http\Request;


class BlockchainController extends PaymentGatewayController
{
    public function __construct()
    {
        parent::__construct('blockchain');
    
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
//    public static function process($deposit)
//    {

//        $blockchainAcc = json_decode($deposit->gateway_currency()->gateway_parameter);
//
//        $all = curlContent("https://blockchain.info/ticker");
//        $res = json_decode($all);
//        $btcrate = $res->USD->last;
//
//        $usd = $deposit->final_amo;
//        $btcamount = $usd / $btcrate;
//        $btc = round($btcamount, 8);
//
//        $data = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();
//        if ($data->btc_amo == 0 || $data->btc_wallet == "") {
//            $blockchain_receive_root = "https://api.blockchain.info/";
//            $secret = "ABIR";
//            $my_xpub = trim($blockchainAcc->xpub_code);
//            $my_api_key = trim($blockchainAcc->api_key);
//            $invoice_id = $data->trx;
//            $callback_url = route('ipn.'.$deposit->gateway->alias) . "?invoice_id=" . $invoice_id . "&secret=" . $secret;
//            $resp = curlContent($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);
//            $response = json_decode($resp);
//            if (@$response->address == '') {
//                $send['error'] = true;
//                $send['message'] = 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER. ' . $response->message;
//            } else {
//
//                $sendto = $response->address;
//                $data['btc_wallet'] = $sendto;
//                $data['btc_amo'] = $btc;
//                $data->update();
//            }
//        }
//        $DepositData = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();
//        $send['amount'] = $DepositData->btc_amo;
//        $send['sendto'] = $DepositData->btc_wallet;
//        $send['img'] = cryptoQR($DepositData->btc_wallet, $DepositData->btc_amo);
//        $send['currency'] = "BTC";
//        $send['view'] = 'user.payment.crypto';
//        return json_encode($send);
//    }
//
//    public function ipn()
//    {
//        $track = $_GET['invoice_id'];
//        $value_in_btc = $_GET['value'] / 100000000;
//        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
//        if ($data->btc_amo == $value_in_btc && $_GET['address'] == $data->btc_wallet && $_GET['secret'] == "ABIR" && $_GET['confirmations'] > 2 && $data->status == 0) {
//            PaymentController::userDataUpdate($data->trx);
//        }
//    }
    
}
