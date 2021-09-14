<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\NewsSubscribe\NewsSubscribeRepositoryEloquent;
use App\Domain\Repositories\NewsSubscribe\NewsSubscribeRepositoryInterface;

class NewsSubscribeRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            NewsSubscribeRepositoryInterface::class,
            NewsSubscribeRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
