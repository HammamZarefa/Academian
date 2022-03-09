<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflinePaymentMethod extends Model
{
    protected $casts = [
        'settings' => 'object',
        'inactive' => 'boolean'
    ];

    protected $fillable = [
        'slug',
        'name',
        'description',
        'instruction',
        'settings',
        'success_message',
        'inactive'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
