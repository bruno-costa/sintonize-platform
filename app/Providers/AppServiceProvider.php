<?php

namespace App\Providers;

use App\Services\ViewStateController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::serializeUsing(function(Carbon $date) {
            return $date->toIso8601ZuluString();
        });
        Schema::defaultStringLength(191);

        $this->app->singleton(ViewStateController::class, function ($app) {
            return new ViewStateController;
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
