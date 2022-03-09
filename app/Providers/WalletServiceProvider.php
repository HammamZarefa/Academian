<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WalletService;
use Illuminate\Database\Eloquent\Relations\Relation;

class WalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\WalletService', function ($app, $params) {
            return new WalletService($params['walletOwnerModel']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'payment'           => 'App\Payment',
            'order'             => 'App\Order',
            // We cannot add App\User as it is being used in Spatie Permission                 
        ]);
    }
}
