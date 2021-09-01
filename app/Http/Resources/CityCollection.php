<?php

namespace App\Http\Resources;

use App\Domain\Contracts\CityContract;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return new CityResource($item);
        });
    }
}
