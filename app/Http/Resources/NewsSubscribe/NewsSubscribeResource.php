<?php

namespace App\Http\Resources\NewsSubscribe;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsSubscribeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::ORGANIZATION_ID   =>  $this->{MainContract::ORGANIZATION_ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
