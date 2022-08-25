<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineService extends Model
{
    protected $table='online_services';
    protected $fillable=['name','price','desc', 'route','created_at','updated_at'];
}
