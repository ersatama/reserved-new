<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Contracts\UserContract;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            UserContract::ID    =>  $this->{UserContract::ID},
            UserContract::BLOCKED   =>  $this->{UserContract::BLOCKED},
            UserContract::NAME      =>  $this->{UserContract::NAME},
            UserContract::AVATAR    =>  $this->{UserContract::AVATAR},
            UserContract::PHONE     =>  $this->{UserContract::PHONE},
            UserContract::PHONE_VERIFIED_AT =>  $this->{UserContract::PHONE_VERIFIED_AT},
            UserContract::EMAIL     =>  $this->{UserContract::EMAIL},
            UserContract::EMAIL_VERIFIED_AT =>  $this->{UserContract::EMAIL_VERIFIED_AT},
            UserContract::API_TOKEN =>  $this->{UserContract::API_TOKEN},
            UserContract::LANGUAGE_ID   =>  $this->{UserContract::LANGUAGE_ID},
            UserContract::EMAIL_NOTIFICATION    =>  $this->{UserContract::EMAIL_NOTIFICATION},
            UserContract::PUSH_NOTIFICATION     =>  $this->{UserContract::PUSH_NOTIFICATION},
        ];
    }
}
