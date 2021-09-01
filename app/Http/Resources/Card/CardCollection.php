<?php

namespace App\Http\Resources\Card;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CardCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new CardResource($request);
        });
    }
}
