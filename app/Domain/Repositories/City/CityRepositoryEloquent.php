<?php


namespace App\Domain\Repositories\City;

use App\Domain\Contracts\MainContract;
use App\Models\City;
use App\Domain\Contracts\CityContract;
use Illuminate\Support\Facades\DB;

class CityRepositoryEloquent implements CityRepositoryInterface
{
    public function getById($id)
    {
        return DB::table(CityContract::TABLE)->where(MainContract::ID,$id)->first();
    }
}
