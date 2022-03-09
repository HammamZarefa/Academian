<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Wallet\Transactionable;

class Payment extends Model
{
	use Transactionable;

    protected $fillable = [
        'number',
        'user_id',
        'method',
        'amount',
        'reference',
        'attachment'     
    ];


    function from()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    
}
