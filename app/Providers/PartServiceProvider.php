<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PartService;

class PartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PartService::class, function ($app) {
            return new PartService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

