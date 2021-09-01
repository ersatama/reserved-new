<?php

namespace App\Http\Resources\Telegram;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Contracts\TelegramContract;

class TelegramResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            TelegramContract::ID    =>  $this->{TelegramContract::ID},
            TelegramContract::API_TOKEN =>  $this->{TelegramContract::API_TOKEN},
            TelegramContract::STATUS    =>  $this->{TelegramContract::STATUS},
        ];
    }
}
