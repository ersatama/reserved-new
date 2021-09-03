<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\Tags\TagsRepositoryInterface;
use App\Domain\Repositories\Tags\TagsRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class TagsRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            TagsRepositoryInterface::class,
            TagsRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
