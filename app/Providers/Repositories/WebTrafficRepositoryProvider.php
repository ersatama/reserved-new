<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\WebTraffic\WebTrafficRepositoryEloquent;
use App\Domain\Repositories\WebTraffic\WebTrafficRepositoryInterface;

class WebTrafficRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            WebTrafficRepositoryInterface::class,
            WebTrafficRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
