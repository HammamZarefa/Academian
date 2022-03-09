<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'number',
        'comment'
    ];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function order()
    {
        return $this->belongsTo('App\Order');
    }
}
