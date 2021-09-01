<?php

namespace App\Http\Resources;

use App\Domain\Contracts\CityContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            CityContract::ID         =>  $this->id,
            CityContract::COUNTRY_ID    =>  $this->country_id,
            CityContract::TITLE      =>  $this->title,
            CityContract::TITLE_KZ   =>  $this->title_kz,
            CityContract::TITLE_EN   =>  $this->title_en,
        ];
    }
}
