<?php

namespace App\Services;

use App\Payment;
use App\NumberGenerator;

class PaymentRecordService
{
    /*
		PaymentRecordService records payments in payments table and the balance
        are added to the wallets table and transaction log in wallet_transactions table
	*/

    public function store($payerUserId, $paymetMethod, $amount, $transactionReference, $attachment = null)
    {
        $payment = Payment::create([
            'number' => NumberGenerator::gen('App\Payment'),
            'user_id' => $payerUserId,
            'method' => $paymetMethod,
            'amount' => $amount,
            'reference' => $transactionReference,
            'attachment' => $attachment,
        ]);
        $payment->from->wallet()->deposit($payment->amount, $payment);

        return $payment;
    }
}
