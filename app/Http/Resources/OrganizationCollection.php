<?php

namespace App\Http\Resources;

use App\Models\Organization;
use App\Models\OrganizationImage;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Domain\Contracts\OrganizationContract;

class OrganizationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new OrganizationResource($request);
        });
    }
}
