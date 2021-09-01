<?php

namespace App\Http\Resources;

use App\Domain\Contracts\OrganizationTableListContract;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationTableListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            OrganizationTableListContract::ID   =>  $this->{OrganizationTableListContract::ID},
            OrganizationTableListContract::TITLE    =>  $this->{OrganizationTableListContract::TITLE},
            OrganizationTableListContract::ORGANIZATION_ID  =>  $this->{OrganizationTableListContract::ORGANIZATION_ID},
            OrganizationTableListContract::ORGANIZATION_TABLE_ID    =>  $this->{OrganizationTableListContract::ORGANIZATION_TABLE_ID},
            OrganizationTableListContract::LIMIT   =>  $this->{OrganizationTableListContract::LIMIT},
            OrganizationTableListContract::PRICE   =>  $this->{OrganizationTableListContract::PRICE},
            OrganizationTableListContract::STATUS   =>  $this->{OrganizationTableListContract::STATUS},
        ];
    }
}
