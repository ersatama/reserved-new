<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\TagsOption\TagsOptionRepositoryEloquent;
use App\Domain\Repositories\TagsOption\TagsOptionRepositoryInterface;

class TagsOptionRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            TagsOptionRepositoryInterface::class,
            TagsOptionRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
