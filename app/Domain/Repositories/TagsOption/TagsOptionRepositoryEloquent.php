<?php

namespace App\Domain\Repositories\TagsOption;

use App\Domain\Contracts\MainContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Domain\Contracts\TagsOptionContract;

class TagsOptionRepositoryEloquent implements TagsOptionRepositoryInterface
{
    public function other(): Collection
    {
        return DB::table(TagsOptionContract::TABLE)
            ->where(MainContract::TAGS_ID,NULL)
            ->get();
    }

    public function getByTitle($tag)
    {
        return DB::table(TagsOptionContract::TABLE)
            ->where(MainContract::TITLE,$tag)
            ->orWhere(MainContract::TITLE_KZ,$tag)
            ->orWhere(MainContract::TITLE_EN,$tag)
            ->first();
    }

    public function all()
    {
        return DB::table(TagsOptionContract::TABLE)
            ->where(MainContract::STATUS,MainContract::ON)
            ->get();
    }

    public function list(): array
    {
        return DB::table(TagsOptionContract::TABLE)->select(MainContract::TITLE)->get()->toArray();
    }
}
