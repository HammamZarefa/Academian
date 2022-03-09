<?php
namespace App\Services;

use App\Traits\Wallet\WalletServiceHelper;

class WalletService
{
    use WalletServiceHelper;

    private $model;
    private $wallet;

    function __construct($model){

        $this->model = $model;
    }

    public function balance()
    {
       return $this->wallet()->balance;
    }

    public function deposit($amount, $transactionableEntity)
    {       
        return $this->add($amount, 'Deposit', $transactionableEntity);
    }

    public function gift($amount, $transactionableEntity, $desctiption = NULL)
    {       
        $$desctiption = ($desctiption) ? $desctiption : 'Gift';
        return $this->add($amount, 'Gift', $transactionableEntity);
    }
    

    public function pay($amount, $transactionableEntity)
    {   
        return $this->deduct($amount, 'Spent', $transactionableEntity);     
    }

    public function refund($amount, $transactionableEntity)
    {       
        return $this->add($amount, 'Refund', $transactionableEntity);
    }

    

}