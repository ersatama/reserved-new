<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Contracts\ReviewContract;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            ReviewContract::ID              =>  $this->id,
            ReviewContract::ORGANIZATION    =>  new OrganizationResource($this->organization),
            ReviewContract::USER            =>  new UserResource($this->user),
            ReviewContract::RATING          =>  $this->rating,
            ReviewContract::COMMENT         =>  $this->comment,
            ReviewContract::STATUS          =>  $this->{ReviewContract::STATUS},
            ReviewContract::CREATED_AT      =>  \Carbon\Carbon::createFromTimeStamp(strtotime($this->{ReviewContract::CREATED_AT}))->diffForHumans()
        ];
    }
}
