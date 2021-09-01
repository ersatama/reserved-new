<?php

namespace App\Http\Resources\OrganizationImage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationImageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new OrganizationImageResource($request);
        });
    }
}
