<?php


namespace App\Domain\Repositories\Category;

use App\Domain\Contracts\CategoryContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepositoryEloquent implements CategoryRepositoryInterface
{
    public function list(): Collection
    {
        return DB::table(CategoryContract::TABLE)->get();
    }

    public function getBySlug($slug)
    {
        return DB::table(CategoryContract::TABLE)->where(MainContract::SLUG,$slug)->first();
    }
}
