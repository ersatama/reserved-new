<?php

namespace App\Http\Resources\Booking;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationTableList\OrganizationTableListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Payment\PaymentService;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID =>  $this->{MainContract::ID},
            MainContract::USER_ID    =>  $this->{MainContract::USER_ID},
            MainContract::ORGANIZATION_ID    =>  $this->{MainContract::ORGANIZATION_ID},
            MainContract::ORGANIZATION_TABLE_LIST_ID =>  $this->{MainContract::ORGANIZATION_TABLE_LIST_ID},
            MainContract::TIME   =>  $this->{MainContract::TIME},
            MainContract::DATE   =>  $this->{MainContract::DATE},
            MainContract::COMMENT    =>  $this->{MainContract::COMMENT},
            MainContract::PAYMENT_URL    =>  $this->{MainContract::PAYMENT_URL},
            MainContract::PAYMENT_ID =>  $this->{MainContract::PAYMENT_ID},
            MainContract::CARD_ID    =>  $this->{MainContract::CARD_ID},
            MainContract::PRICE  =>  $this->{MainContract::PRICE},
            MainContract::CURRENCY   =>  $this->{MainContract::CURRENCY},
            MainContract::PG_SIG =>  PaymentService::paySignature($this->{MainContract::PAYMENT_ID}),
            MainContract::ORGANIZATION   =>  new OrganizationResource($this->{MainContract::ORGANIZATION}),
            MainContract::ORGANIZATION_TABLES    =>  new OrganizationTableListResource($this->{MainContract::ORGANIZATION__TABLES}),
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::USER  =>  $this->{MainContract::USER}
        ];
    }
}
