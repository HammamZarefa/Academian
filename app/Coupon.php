<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'id',
        'code',
        'amount',
        'quantity',
        'type',
        'status',
        'description',
        'start_at',
        'expired_at'
    ];
}
