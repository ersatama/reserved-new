<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Domain\Contracts\LanguagesContract;

class LanguageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            LanguagesContract::ID   =>  $this->{LanguagesContract::ID},
            LanguagesContract::TITLE    =>  $this->{LanguagesContract::TITLE}
        ];
    }
}
