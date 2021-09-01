<?php

namespace App\Http\Resources;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\OrganizationTableList\OrganizationTableListCollection;

class OrganizationTablesResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID  =>  $this->{MainContract::ID},
            MainContract::NAME   =>  $this->{MainContract::NAME},
            MainContract::STATUS  =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  Carbon::createFromTimeStamp(strtotime($this->{MainContract::CREATED_AT}))->diffForHumans(),
            MainContract::ORGANIZATION_TABLES =>  new OrganizationTableListCollection($this->{MainContract::ORGANIZATION__TABLES})
        ];
    }
}
