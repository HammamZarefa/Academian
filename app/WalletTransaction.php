<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    public function relatedTable()
    {
        return $this->morphTo('transactionable');
    }
    public function getReferenceLink()
    {
        if ($this->transactionable_type == 'order') {
            return anchor($this->relatedTable->number, route('orders_show', $this->transactionable_id));
        }
        if ($this->transactionable_type == 'payment') {
            return $this->relatedTable->number;
        }
    }
}
