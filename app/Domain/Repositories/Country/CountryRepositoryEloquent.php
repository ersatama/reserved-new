<?php


namespace App\Domain\Repositories\Country;

use App\Domain\Contracts\CountryContract;
use App\Models\Country;

class CountryRepositoryEloquent implements CountryRepositoryInterface
{
    public function list()
    {
        return Country::with('city')->get();
    }
}
