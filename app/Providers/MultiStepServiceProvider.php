<?php

namespace App\Providers;

use App\MultiStep\Routing\PendingMultiStepRegistration;
use App\MultiStep\Store\Contracts\StepStorage;
use App\MultiStep\Store\SessionStorage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MultiStepServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StepStorage::class, function () {
            return new SessionStorage(request());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro('multistep', function ($uri, $controller) {
            return new PendingMultiStepRegistration(
                $uri, $controller
            );
        });
    }
}
