<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LanguageCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new LanguageResource($request);
        });
    }
}
