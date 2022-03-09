<?php

namespace App\Traits\Wallet;

use Illuminate\Database\Eloquent\Relations\morphToMany;
use App\Services\WalletService;

trait HasWallet
{
  public function transactions(): morphToMany
  {
    return $this->morphToMany('App\Wallet', 'walletable');
  }

  public function wallet()
  {
    return app()->makeWith('App\Services\WalletService', [
      'walletOwnerModel' => $this->getModel()
    ]);
  }
}
