<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'number',        
        'user_id',        
    ];

}
