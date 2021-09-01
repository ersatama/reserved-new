<?php

namespace App\Http\Resources\OrganizationImage;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::IMAGE =>  $this->{MainContract::IMAGE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
        ];
    }
}
