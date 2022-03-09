<?php
namespace App\Traits\Wallet;

use App\Wallet;
use App\NumberGenerator;

trait WalletServiceHelper
{
    private function add($amount, $description, $transactionableEntity)
    {
        $wallet = $this->wallet();         
        $wallet->balance = $wallet->balance + $amount;
        $wallet->save();

        $transactionableEntity->walletTransactions()->attach($wallet->id,[
            'number' => NumberGenerator::gen('App\Wallet'),
            'description' => $description,
            'amount' => $amount,
            'balance' => $wallet->balance,
        ]);

        return $wallet;
    }

    private function deduct($amount, $description, $transactionableEntity)
    {
        $wallet = $this->wallet();         
        $wallet->balance = $wallet->balance - $amount;
        $wallet->save();

        $transactionableEntity->walletTransactions()->attach($wallet->id,[
            'number' => NumberGenerator::gen('App\Wallet'),
            'description' => $description,
            'amount' => -$amount,
            'balance' => $wallet->balance,
        ]);

        return $wallet;
    }

    private function wallet()
    {
        return Wallet::firstOrCreate(['user_id' => $this->model->id],[
            'user_id' => $this->model->id,
            'balance' => 0
        ]);      
    }    
   
}
