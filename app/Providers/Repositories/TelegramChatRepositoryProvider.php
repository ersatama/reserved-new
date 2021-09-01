<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\TelegramChat\TelegramChatRepositoryEloquent;
use App\Domain\Repositories\TelegramChat\TelegramChatRepositoryInterface;

class TelegramChatRepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            TelegramChatRepositoryInterface::class,
            TelegramChatRepositoryEloquent::class
        );
    }

    public function boot()
    {
        //
    }
}
