<?php

namespace App\Domain\Repositories\Telegram;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\TelegramContract;
use App\Models\Telegram;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TelegramRepositoryEloquent implements TelegramRepositoryInterface
{
    public function create($data)
    {
        return Telegram::create($data);
    }

    public function update($id, $data)
    {
        Telegram::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getByUserId($userId): Collection
    {
        return DB::table(TelegramContract::TABLE)
            ->where([
                [MainContract::USER_ID,$userId],
                [MainContract::STATUS,'!=', MainContract::OFF]
            ])->get();
    }

    public function getById($id)
    {
        return DB::table(TelegramContract::TABLE)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,'!=', MainContract::OFF]
            ])->first();
    }

}
