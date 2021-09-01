<?php

namespace App\Providers;

use App\Domain\Repositories\OrganizationTable\OrganizationTableRepositoryEloquent;
use App\Domain\Repositories\OrganizationTable\OrganizationTableRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrganizationTablesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrganizationTableRepositoryInterface::class,
            OrganizationTableRepositoryEloquent::class
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
