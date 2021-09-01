<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\Iiko\IikoTables\IikoTablesRepositoryInterface;
use App\Domain\Repositories\Iiko\IikoTables\IikoTablesRepositoryEloquent;

class IikoTablesRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IikoTablesRepositoryInterface::class,
            IikoTablesRepositoryEloquent::class
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
