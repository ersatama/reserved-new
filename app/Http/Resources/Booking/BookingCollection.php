<?php

namespace App\Http\Resources\Booking;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            return new BookingResource($request);
        });
    }
}
