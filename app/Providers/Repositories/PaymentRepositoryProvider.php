<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\Payment\PaymentRepositoryEloquent;
use App\Domain\Repositories\Payment\PaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PaymentRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepositoryEloquent::class
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
