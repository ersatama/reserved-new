<?php

namespace App\Http\Resources;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID        =>  $this->{MainContract::ID},
            MainContract::CITY_ID   =>  $this->{MainContract::CITY_ID},
            MainContract::RATING    =>  $this->{MainContract::RATING},
            MainContract::IMAGE     =>  $this->{MainContract::IMAGE}?:'/img/logo/reserved-logo.png',
            MainContract::WALLPAPER =>  $this->{MainContract::WALLPAPER}?:'/img/logo/wall.png',
            MainContract::TITLE     =>  $this->{MainContract::TITLE},
            MainContract::TIME      =>  '-',
            MainContract::PHONE     =>  $this->{MainContract::PHONE},
            MainContract::EMAIL     =>  $this->{MainContract::EMAIL},
            MainContract::WEBSITE   =>  $this->{MainContract::WEBSITE},
            MainContract::INSTAGRAM =>  $this->{MainContract::INSTAGRAM},
            MainContract::YOUTUBE   =>  $this->{MainContract::YOUTUBE},
            MainContract::VK        =>  $this->{MainContract::VK},
            MainContract::FACEBOOK  =>  $this->{MainContract::FACEBOOK},
            MainContract::CATEGORY  =>  $this->{MainContract::CATEGORY_ID},
            MainContract::DESCRIPTION       =>  $this->{MainContract::DESCRIPTION},
            MainContract::DESCRIPTION_KZ    =>  $this->{MainContract::DESCRIPTION_KZ},
            MainContract::DESCRIPTION_EN    =>  $this->{MainContract::DESCRIPTION_EN},
            MainContract::_2GIS     =>  $this->{MainContract::_2GIS},
            MainContract::ADDRESS       =>  $this->{MainContract::ADDRESS},
            MainContract::ADDRESS_KZ    =>  $this->{MainContract::ADDRESS_KZ},
            MainContract::ADDRESS_EN    =>  $this->{MainContract::ADDRESS_EN},
            MainContract::PRICE     =>  $this->{MainContract::PRICE},
            MainContract::TABLES    =>  $this->{MainContract::TABLES},
            MainContract::MONDAY    =>  [
                MainContract::START =>  $this->{MainContract::START_MONDAY},
                MainContract::END   =>  $this->{MainContract::END_MONDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_MONDAY},
            ],
            MainContract::TUESDAY   =>  [
                MainContract::START =>  $this->{MainContract::START_TUESDAY},
                MainContract::END   =>  $this->{MainContract::END_TUESDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_TUESDAY},
            ],
            MainContract::WEDNESDAY =>  [
                MainContract::START =>  $this->{MainContract::START_WEDNESDAY},
                MainContract::END   =>  $this->{MainContract::END_WEDNESDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_WEDNESDAY},
            ],
            MainContract::THURSDAY  =>  [
                MainContract::START =>  $this->{MainContract::START_THURSDAY},
                MainContract::END   =>  $this->{MainContract::END_THURSDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_THURSDAY},
            ],
            MainContract::FRIDAY    =>  [
                MainContract::START =>  $this->{MainContract::START_FRIDAY},
                MainContract::END   =>  $this->{MainContract::END_FRIDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_FRIDAY},
            ],
            MainContract::SATURDAY  =>  [
                MainContract::START =>  $this->{MainContract::START_SATURDAY},
                MainContract::END   =>  $this->{MainContract::END_SATURDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_SATURDAY},
            ],
            MainContract::SUNDAY    =>  [
                MainContract::START =>  $this->{MainContract::START_SUNDAY},
                MainContract::END   =>  $this->{MainContract::END_SUNDAY},
                MainContract::WORK  =>  $this->{MainContract::WORK_SUNDAY},
            ],
            MainContract::STATUS        =>  $this->{MainContract::STATUS},
            MainContract::CATEGORY_ID   =>  new CategoryResource($this->{MainContract::CATEGORY}),
        ];
    }
}
