<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Wallet\Transactionable;
use Spatie\Translatable\HasTranslations;

class Payment extends Model
{
	use Transactionable;
    use HasTranslations;

    protected $fillable = [
        'number',
        'user_id',
        'method',
        'amount',
        'reference',
        'attachment'
    ];

    public $translatable = ['method'];


    function from()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


}
