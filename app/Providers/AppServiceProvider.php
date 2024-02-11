<?php

namespace App\Providers;

use App\Models\PriceList;
use App\Models\PriceListElement;
use App\Observers\PriceListElementObserver;
use App\Observers\PriceListObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PriceList::observe(PriceListObserver::class);
    }
}
