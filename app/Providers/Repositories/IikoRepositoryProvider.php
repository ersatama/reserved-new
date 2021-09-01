<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\Iiko\IikoRepositoryEloquent;
use App\Domain\Repositories\Iiko\IikoRepositoryInterface;

class IikoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IikoRepositoryInterface::class,
            IikoRepositoryEloquent::class
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
