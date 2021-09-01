<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\OrganizationRequest\OrganizationRequestRepositoryEloquent;
use App\Domain\Repositories\OrganizationRequest\OrganizationRequestRepositoryInterface;

class OrganizationRequestRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            OrganizationRequestRepositoryInterface::class,
            OrganizationRequestRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
