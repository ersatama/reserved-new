<?php


namespace App\Domain\Repositories\Organization;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationContract;
use App\Models\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrganizationRepositoryEloquent implements OrganizationRepositoryInterface
{

    private $take   =   15;

    public function getByIds($ids)
    {
        return Organization::with('user','category')->where(MainContract::STATUS,MainContract::ENABLED)->whereIn(MainContract::ID,$ids)->get();
    }

    public function update($id,$data):void
    {
        Organization::find($id)->update($data);
    }

    public function getIdsByUserId(int $userId)
    {
        return Organization::where(MainContract::USER_ID,$userId)->get()->toArray();
    }

    public function list(int $paginate)
    {
        return Organization::with('category')
            ->skip(--$paginate * $this->take)
            ->take($this->take)
            ->get();
    }

    public function searchByTitle(string $search, int $paginate)
    {
        return Organization::with('category')
            ->where(MainContract::TITLE, 'like', '%'.$search.'%')
            ->skip(--$paginate * $this->take)
            ->take($this->take)
            ->get();
    }

    public function getById($id)
    {
        return Organization::with('category')
            ->where(MainContract::ID,$id)
            ->first();
    }

    public function getByCategoryId($id, $paginate)
    {
        return Organization::with('category')
            ->where(MainContract::CATEGORY_ID,$id)
            ->skip(--$paginate * $this->take)
            ->take($this->take)
            ->get();
    }

    public function updateRating($id,$rating)
    {
        return Organization::where(MainContract::ID,$id)->update([
            MainContract::RATING    =>  $rating
        ]);
    }

    public function getByUserId(int $id)
    {
        return Organization::where([
            MainContract::USER_ID   =>  $id,
            MainContract::STATUS    =>  MainContract::ENABLED
        ])->first();
    }

    public function find($search)
    {
        return Organization::where([
            [MainContract::TITLE,'like','%'.$search.'%'],
            [MainContract::STATUS ,MainContract::ENABLED]
        ])->limit(6)->get();
    }

    public function getByCategoryIdAndCityId($id, $cityId, $paginate)
    {
        return Organization::with('category')
        ->where([
            [MainContract::CATEGORY_ID,$id],
            [MainContract::CITY_ID,$cityId],
            [MainContract::STATUS,MainContract::ENABLED]
        ])->get();
    }

    public function getMinAndMaxPrice(): Collection
    {
        return DB::table(OrganizationContract::TABLE)
            ->select(DB::raw('MIN(price) AS max, MAX(price) AS min'))
            ->get();
    }
}
