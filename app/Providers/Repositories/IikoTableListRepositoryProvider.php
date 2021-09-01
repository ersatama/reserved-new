<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\Iiko\IikoTableList\IikoTableListRepositoryInterface;
use App\Domain\Repositories\Iiko\IikoTableList\IikoTableListRepositoryEloquent;

class IikoTableListRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IikoTableListRepositoryInterface::class,
            IikoTableListRepositoryEloquent::class
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
