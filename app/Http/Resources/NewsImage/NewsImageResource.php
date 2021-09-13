<?php

namespace App\Http\Resources\NewsImage;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID        =>  $this->{MainContract::ID},
            MainContract::NEWS_ID   =>  $this->{MainContract::NEWS_ID},
            MainContract::IMAGE     =>  $this->{MainContract::IMAGE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
