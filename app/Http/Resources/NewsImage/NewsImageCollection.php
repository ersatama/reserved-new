<?php

namespace App\Http\Resources\NewsImage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsImageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new NewsImageResource($request);
        });
    }
}
