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

        $rec->key = $this->gateway->keys->api_key;
        $rec->salt = $this->gateway->keys->xpub_code;
        $rec->amount = $this->cart->getTotal();
        $rec->fname = auth()->user()->first_name;
        $rec->email = auth()->user()->email;
        $rec->txnid = rand(10000,99999999);
        $rec->pinfo = 'service';
        $rec->udf5 = 'BOLT_KIT_PHP7';
        $rec->phone = "23423";
        $rec->surl = route('blockchain_payment_captured');
        $rec->furl = route('blockchain_payment_captured');
        $error = null;

        try {
            $data['rec'] = $rec;
//            $data['hash'] = $this->generateHash($rec);
            $data['total'] = $this->cart->getTotal();
            $data['gateway_name'] = $this->gateway->name;
//            $data['environment'] = $this->gateway->keys->environment;
            return view($this->getPaymentView(), compact('data'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While generating hash');
        }

        return $this->redirectOnFailedTokenGeneration();
    }

    public function verifyPayment(Request $request)
    {
         $my_xpub =$this->gateway->keys->xpub_code;
            $my_api_key = $this->gateway->keys->api_keyockchainAcc->api_key;
       $all = curlContent("https://blockchain.info/ticker");
        $res = json_decode($all);
        $btcrate =5; //$res->USD->last;
        $usd =5;//osit->final_amo;
        $btcamount = $usd / $btcrate;
        $btc = round($btcamount, 8);
        $blockchain_receive_root = "https://api.blockchain.info/";
        $secret = "ABIR";
        $callback_url = route('ipn.'.$this->gatewayUniqueName)  . "?secret=" . $secret;
            $resp = curlContent($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);
            $response = json_decode($resp);
            if (@$response->address == '') {
                $send['error'] = true;
                $send['message'] = 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER. ' ;//. $response->message;
            } else {

                $sendto = $response->address;
                $data['btc_wallet'] = $sendto;
                $data['btc_amo'] = $btc;
                $data->update();
            }


//        $response = json_decode(curl_exec($curl));
//        $error = curl_error($curl);
//        curl_close($curl);

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
