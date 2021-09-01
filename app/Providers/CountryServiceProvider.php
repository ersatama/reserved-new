<?php

namespace App\Providers;

use App\Domain\Repositories\Country\CountryRepositoryEloquent;
use App\Domain\Repositories\Country\CountryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CountryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepositoryEloquent::class
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
