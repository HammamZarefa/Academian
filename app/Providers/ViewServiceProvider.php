<?php

namespace App\Providers;

use App\Http\View\Composers\SiteComposer;
use App\ServiceCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('service_categories', SiteComposer::class);
        View::composer('service_categories', function ($view) {

            // following code will create $posts variable which we can use
            // in our post.list view you can also create more variables if needed
            $view->with('service_category',ServiceCategory::all());
        });
    }
}
