<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Domain\Contracts\OrganizationImageContract;

class OrganizationImageCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                OrganizationImageContract::ID   =>  $item->id,
                OrganizationImageContract::IMAGE    =>  $item->image,
            ];
        });
    }
}
