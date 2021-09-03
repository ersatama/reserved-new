<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\TagsOptionOrganization\TagsOptionOrganizationRepositoryEloquent;
use App\Domain\Repositories\TagsOptionOrganization\TagsOptionOrganizationRepositoryInterface;

class TagsOptionOrganizationRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            TagsOptionOrganizationRepositoryInterface::class,
            TagsOptionOrganizationRepositoryEloquent::class,
        );
    }

    public function boot()
    {
        //
    }
}
