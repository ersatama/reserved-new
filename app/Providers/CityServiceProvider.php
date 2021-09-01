<?php

namespace App\Providers;

use App\Domain\Repositories\City\CityRepositoryEloquent;
use App\Domain\Repositories\City\CityRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
