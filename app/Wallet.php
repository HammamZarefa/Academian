<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{	
	protected $fillable = [
        'user_id',
        'balance'        
    ];

    /**
     * Get the owning commentable model.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function transactions()
    {
        return $this->hasMany('App\WalletTransaction', 'wallet_id')->with('relatedTable');
    }
}
