<?php

namespace App\Http\Resources\News;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\NewsImage\NewsImageCollection;
use App\Http\Resources\OrganizationResource;
use Carbon\Carbon;

class NewsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>    $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::DESCRIPTION   =>  $this->{MainContract::DESCRIPTION},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::ORGANIZATION  =>  new OrganizationResource($this->{MainContract::ORGANIZATION}),
            MainContract::IMAGES    =>  new NewsImageCollection($this->{MainContract::NEWS_IMAGES}),
            MainContract::CREATED_AT    =>  Carbon::createFromTimeStamp(strtotime($this->{MainContract::CREATED_AT}))->diffForHumans()

        ];
    }
}
