<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\Organization\OrganizationRepositoryEloquent;
use App\Domain\Repositories\Organization\OrganizationRepositoryInterface;

class OrganizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrganizationRepositoryInterface::class,
            OrganizationRepositoryEloquent::class
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
