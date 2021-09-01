<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\Link\LinkRepositoryInterface;
use App\Domain\Repositories\Link\LinkRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class LinkRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LinkRepositoryInterface::class,
            LinkRepositoryEloquent::class
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
