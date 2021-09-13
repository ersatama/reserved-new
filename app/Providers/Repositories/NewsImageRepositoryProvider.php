<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\NewsImage\NewsImageRepositoryEloquent;
use App\Domain\Repositories\NewsImage\NewsImageRepositoryInterface;

class NewsImageRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NewsImageRepositoryInterface::class,
            NewsImageRepositoryEloquent::class
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
