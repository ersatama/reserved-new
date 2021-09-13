<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\News\NewsRepositoryEloquent;
use App\Domain\Repositories\News\NewsRepositoryInterface;

class NewsRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            NewsRepositoryInterface::class,
            NewsRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
