<?php

namespace App\Http\Resources\OrganizationTableList;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationTableListResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID   =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::ORGANIZATION_ID  =>  $this->{MainContract::ORGANIZATION_ID},
            MainContract::ORGANIZATION_TABLE_ID =>  $this->{MainContract::ORGANIZATION_TABLE_ID},
            MainContract::PRICE =>  $this->{MainContract::PRICE},
            MainContract::LIMIT   =>  $this->{MainContract::LIMIT},
            MainContract::STATUS   =>  $this->{MainContract::STATUS},
        ];
    }
}
