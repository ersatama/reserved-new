<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\OrganizationImage\OrganizationImageRepositoryEloquent;
use App\Domain\Repositories\OrganizationImage\OrganizationImageRepositoryInterface;

class OrganizationImageRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            OrganizationImageRepositoryInterface::class,
            OrganizationImageRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
