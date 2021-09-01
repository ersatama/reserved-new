<?php

namespace App\Http\Resources\Telegram;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TelegramCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new TelegramResource($request);
        });
    }
}
