<?php

namespace App\Http\Resources;

use App\Domain\Contracts\ReviewContract;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return new ReviewResource($item);
        });
    }
}
