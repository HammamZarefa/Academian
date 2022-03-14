<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Wallet\Transactionable;
use Spatie\Translatable\HasTranslations;

class PendingForApprovalPayment extends Model
{
    use Transactionable;
    use HasTranslations;

    protected $fillable = [
        'user_id',
        'method',
        'amount',
        'reference',
        'attachment',
        'status',
        'payment_reason',
        'cart',
        'payment_reasonable_id'
    ];

    public $translatable = ['method'];

    protected $casts = [
        'cart' => 'object',
    ];

    function from()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
