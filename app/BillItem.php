<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'total',
        'bill_id'
    ];

    function bill()
    {
        return $this->belongsTo('App\Bill');
    }

    function order()
    {
        return $this->belongsTo('App\Order');
    }
}
