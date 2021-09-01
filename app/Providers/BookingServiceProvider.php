<?php

namespace App\Providers;

use App\Domain\Repositories\Booking\BookingRepositoryEloquent;
use App\Domain\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class BookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BookingRepositoryInterface::class,
            BookingRepositoryEloquent::class
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
