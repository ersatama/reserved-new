<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\Card\CardRepositoryInterface;
use App\Domain\Repositories\Card\CardRepositoryEloquent;

class CardRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            CardRepositoryInterface::class,
            CardRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
