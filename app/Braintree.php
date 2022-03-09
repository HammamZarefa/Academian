<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Braintree extends Model
{

    public $timestamps = false;

    protected $casts = [
        'is_paypal_enabled' => 'boolean'
    ];

    protected $fillable = [
        'environment',
        'merchant_id',
        'public_key',
        'private_key',
        'is_paypal_enabled'
    ];
}
