<?php


namespace App\Domain\Repositories\Card;

use App\Domain\Contracts\MainContract;
use App\Models\Card;
use App\Domain\Contracts\CardContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CardRepositoryEloquent implements CardRepositoryInterface
{
    public function create(array $data)
    {
        return Card::create($data);
    }

    public function update($id, array $data):void
    {
        DB::table(CardContract::TABLE)
            ->where(MainContract::ID,$id)
            ->update($data);
    }

    public function getById($id)
    {
        return DB::table(CardContract::TABLE)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS, MainContract::ON]
            ])->first();
    }

    public function getByUserId($userId):Collection
    {
        return DB::table(CardContract::TABLE)
            ->where([
                [MainContract::USER_ID,$userId],
                [MainContract::STATUS, MainContract::ON]
            ])->get();
    }

}
