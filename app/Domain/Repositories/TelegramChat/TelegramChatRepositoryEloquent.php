<?php

namespace App\Domain\Repositories\TelegramChat;

use App\Domain\Contracts\MainContract;
use App\Models\TelegramChat;
use App\Domain\Contracts\TelegramChatContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TelegramChatRepositoryEloquent implements TelegramChatRepositoryInterface
{
    public function create($data)
    {
        return TelegramChat::create($data);
    }

    public function getByTelegramId($telegramId): Collection
    {
        return DB::table(TelegramChatContract::TABLE)->where([
            [MainContract::TELEGRAM_ID,$telegramId],
            [MainContract::STATUS, MainContract::ON]
        ])->get();
    }

    public function getByChatId($chatId)
    {
        return DB::table(TelegramChatContract::TABLE)->where([
            [MainContract::TELEGRAM_CHAT_ID,$chatId],
            [MainContract::STATUS, MainContract::ON]
        ])->first();
    }

    public function update($chatId,$data):void
    {
        DB::table(TelegramChatContract::TABLE)
            ->where(MainContract::TELEGRAM_CHAT_ID,$chatId)
            ->update($data);
    }

}
