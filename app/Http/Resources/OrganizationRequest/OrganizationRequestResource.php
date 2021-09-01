<?php

namespace App\Http\Resources\OrganizationRequest;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Contracts\MainContract;

class OrganizationRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::NAME  =>  $this->{MainContract::NAME},
            MainContract::PHONE =>  $this->{MainContract::PHONE},
            MainContract::ORGANIZATION_NAME =>  $this->{MainContract::ORGANIZATION_NAME},
            MainContract::CATEGORY_ID   =>  $this->{MainContract::CATEGORY_ID},
            MainContract::CITY_ID   =>  $this->{MainContract::CITY_ID},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
        ];
    }
}
