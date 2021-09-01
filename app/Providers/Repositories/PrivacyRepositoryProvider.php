<?php

namespace App\Providers\Repositories;

use App\Domain\Repositories\Privacy\PrivacyRepositoryInterface;
use App\Domain\Repositories\Privacy\PrivacyRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class PrivacyRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PrivacyRepositoryInterface::class,
            PrivacyRepositoryEloquent::class
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
