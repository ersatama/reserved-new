<?php

namespace App\Domain\Repositories\NewsImage;

use App\Domain\Contracts\MainContract;
use App\Models\NewsImage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Domain\Contracts\NewsImageContract;

class NewsImageRepositoryEloquent implements NewsImageRepositoryInterface
{
    public function create($data)
    {
        return NewsImage::create($data);
    }

    public function update($id, $data)
    {
        DB::table(NewsImageContract::TABLE)->where(
            MainContract::ID,$id
        )->update($data);
    }

    public function getByNewsId($newsId): Collection
    {
        return DB::table(NewsImageContract::TABLE)->where(
            [MainContract::NEWS_ID,$newsId],
            [MainContract::STATUS,'!=',MainContract::OFF]
        )->get();
    }

    public function getById($id)
    {
        return DB::table(NewsImageContract::TABLE)->where(
            [MainContract::ID,$id],
            [MainContract::STATUS,'!=',MainContract::OFF]
        )->first();
    }

}
