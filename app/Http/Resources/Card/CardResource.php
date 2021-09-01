<?php

namespace App\Http\Resources\Card;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            MainContract::ID        =>  $this->{MainContract::ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::CARD_ID   =>  $this->{MainContract::CARD_ID},
            MainContract::HASH      =>  $this->{MainContract::HASH},
            MainContract::MONTH     =>  $this->{MainContract::MONTH},
            MainContract::YEAR      =>  $this->{MainContract::YEAR},
            MainContract::BANK      =>  $this->{MainContract::BANK},
            MainContract::COUNTRY   =>  $this->{MainContract::COUNTRY},
            MainContract::CARD_3D   =>  $this->{MainContract::CARD_3D},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  $this->{MainContract::CREATED_AT},
            MainContract::UPDATED_AT    =>  $this->{MainContract::UPDATED_AT}
        ];
    }
}
