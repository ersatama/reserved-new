<?php

namespace App\Http\Resources;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::TITLE_KZ  =>  $this->{MainContract::TITLE_KZ},
            MainContract::TITLE_EN  =>  $this->{MainContract::TITLE_EN},
            MainContract::SLUG  =>  $this->{MainContract::SLUG},
            MainContract::DESCRIPTION   =>  $this->{MainContract::DESCRIPTION},
            MainContract::DESCRIPTION_KZ    =>  $this->{MainContract::DESCRIPTION_KZ},
            MainContract::DESCRIPTION_EN    =>  $this->{MainContract::DESCRIPTION_EN},
            MainContract::IMAGE =>  $this->{MainContract::IMAGE},
            MainContract::WALLPAPER =>  $this->{MainContract::WALLPAPER},
        ];
    }
}
