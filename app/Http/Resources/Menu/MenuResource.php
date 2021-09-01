<?php

namespace App\Http\Resources\Menu;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::ORGANIZATION_ID   =>  $this->{MainContract::ORGANIZATION_ID},
            MainContract::IMAGE =>  $this->{MainContract::IMAGE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
        ];
    }
}
