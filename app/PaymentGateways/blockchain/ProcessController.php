<?php

namespace App\Http\Controllers\Gateway\blockchain;

use App\Models\Deposit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;

class ProcessController extends Controller
{
    /*
     * Blockchain Pay Gateway
     */

    public static function process($deposit)
    {
        $blockchainAcc = json_decode($deposit->gateway_currency()->gateway_parameter);

        $all = curlContent("https://blockchain.info/ticker");
        $res = json_decode($all);
        $btcrate = $res->USD->last;

        $usd = $deposit->final_amo;
        $btcamount = $usd / $btcrate;
        $btc = round($btcamount, 8);

        $data = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();


        if ($data->btc_amo == 0 || $data->btc_wallet == "") {
            $blockchain_receive_root = "https://api.blockchain.info/";
            $secret = "ABIR";
            $my_xpub = trim($blockchainAcc->xpub_code);
            $my_api_key = trim($blockchainAcc->api_key);
            $invoice_id = $data->trx;
            $callback_url = route('ipn.'.$deposit->gateway->alias) . "?invoice_id=" . $invoice_id . "&secret=" . $secret;
            $resp = curlContent($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);
            $response = json_decode($resp);
            if (@$response->address == '') {
                $send['error'] = true;
                $send['message'] = 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER. ' . $response->message;
            } else {

                $sendto = $response->address;
                $data['btc_wallet'] = $sendto;
                $data['btc_amo'] = $btc;
                $data->update();
            }
        }
        $DepositData = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();
        $send['amount'] = $DepositData->btc_amo;
        $send['sendto'] = $DepositData->btc_wallet;
        $send['img'] = cryptoQR($DepositData->btc_wallet, $DepositData->btc_amo);
        $send['currency'] = "BTC";
        $send['view'] = 'user.payment.crypto';
        return json_encode($send);
    }

    public function ipn()
    {
        $track = $_GET['invoice_id'];
        $value_in_btc = $_GET['value'] / 100000000;
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if ($data->btc_amo == $value_in_btc && $_GET['address'] == $data->btc_wallet && $_GET['secret'] == "ABIR" && $_GET['confirmations'] > 2 && $data->status == 0) {
            PaymentController::userDataUpdate($data->trx);
        }
    }
}
