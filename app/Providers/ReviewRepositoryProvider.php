<?php

namespace App\Providers;

use App\Domain\Repositories\Review\ReviewRepositoryEloquent;
use App\Domain\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ReviewRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepositoryEloquent::class
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
