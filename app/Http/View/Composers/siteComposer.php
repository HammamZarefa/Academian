<?php

namespace App\Http\View\Composers;

use App\ServiceCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SiteComposer
{

    /**
     * Create a new site composer.
     * @return void
     */
    public function __construct()
    {
        // Dependencies are automatically resolved by the service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('service_category',ServiceCategory::all());
    }

    private function settings()
    {
//        return Cache::remember(
//            'global-settings', 120, fn () => Setting::all()->keyBy('key')
//        );
    }

    private function website()
    {
        return Cache::remember('website',120, function (){
            $service_categories=ServiceCategory::all();
            return compact('service_categories');
        });
    }

}
