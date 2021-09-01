<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

use App\Domain\Repositories\Telegram\TelegramRepositoryEloquent;
use App\Domain\Repositories\Telegram\TelegramRepositoryInterface;

class TelegramRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            TelegramRepositoryInterface::class,
            TelegramRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
