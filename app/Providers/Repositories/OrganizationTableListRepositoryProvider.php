<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\OrganizationTableList\OrganizationTableListRepositoryInterface;
use App\Domain\Repositories\OrganizationTableList\OrganizationTableListRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class OrganizationTableListRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrganizationTableListRepositoryInterface::class,
            OrganizationTableListRepositoryEloquent::class
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
