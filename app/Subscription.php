<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    protected $table='subscription';
    protected $fillable=['user_id',
                        'online_service_id',
                        'activity',
                        'created_at',
                        'updated_at'];
}
