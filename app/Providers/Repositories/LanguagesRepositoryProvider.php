<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\Language\LanguagesRepositoryEloquent;
use App\Domain\Repositories\Language\LanguagesRepositoryInterface;

class LanguagesRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LanguagesRepositoryInterface::class,
            LanguagesRepositoryEloquent::class
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
