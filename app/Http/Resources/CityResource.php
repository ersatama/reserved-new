<?php

namespace App\Http\Resources;

use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID         =>  $this->{MainContract::ID},
            MainContract::COUNTRY_ID    =>  $this->{MainContract::COUNTRY_ID},
            MainContract::TIMEZONE  =>  $this->{MainContract::TIMEZONE},
            MainContract::TITLE      =>  $this->{MainContract::TITLE},
            MainContract::TITLE_KZ   =>  $this->{MainContract::TITLE_KZ},
            MainContract::TITLE_EN   =>  $this->{MainContract::TITLE_EN},
        ];
    }
}
