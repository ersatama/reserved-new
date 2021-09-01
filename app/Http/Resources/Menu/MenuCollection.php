<?php

namespace App\Http\Resources\Menu;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new MenuResource($request);
        });
    }
}
