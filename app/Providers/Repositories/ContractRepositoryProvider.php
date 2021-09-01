<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\Contract\ContractRepositoryInterface;
use App\Domain\Repositories\Contract\ContractRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class ContractRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ContractRepositoryInterface::class,
            ContractRepositoryEloquent::class
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
