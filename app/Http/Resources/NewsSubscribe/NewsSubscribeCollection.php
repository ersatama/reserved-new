<?php

namespace App\Http\Resources\NewsSubscribe;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsSubscribeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new NewsSubscribeResource($request);
        });
    }
}
