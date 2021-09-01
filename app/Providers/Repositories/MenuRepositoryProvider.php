<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\Menu\MenuRepositoryEloquent;
use App\Domain\Repositories\Menu\MenuRepositoryInterface;

class MenuRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            MenuRepositoryInterface::class,
            MenuRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
