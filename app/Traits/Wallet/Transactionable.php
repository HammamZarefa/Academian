<?php
namespace App\Traits\Wallet;

use Illuminate\Database\Eloquent\Relations\morphToMany;

trait Transactionable
{
    public function walletTransactions(): morphToMany
    {
        return $this->morphToMany(
        	 // the related model
        	'App\Wallet', 
        	// the relationship name
        	'transactionable',
        	// the table name, 
        	'wallet_transactions'        	
		)->withTimestamps()
		->withPivot('number', 'transactionable_id','amount','description');   
    }
}
