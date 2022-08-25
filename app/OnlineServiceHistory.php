<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineServiceHistory extends Model
{
    protected $table='plagiarisms';
    protected $fillable=['user_id','created_at','updated_at'];
    public $timestamps =true;
}
