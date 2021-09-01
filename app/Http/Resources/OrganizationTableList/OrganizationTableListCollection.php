<?php

namespace App\Http\Resources\OrganizationTableList;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationTableListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new OrganizationTableListResource($request);
        });
    }
}
