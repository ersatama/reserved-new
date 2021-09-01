<?php

namespace App\Http\Resources;

use App\Domain\Contracts\CountryContract;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                CountryContract::ID         =>  $item->id,
                CountryContract::TITLE      =>  $item->title,
                CountryContract::TITLE_KZ   =>  $item->title_kz,
                CountryContract::TITLE_EN   =>  $item->title_en,
                CountryContract::CITY_ID    =>  new CityCollection($item->city)
            ];
        });
    }
}
