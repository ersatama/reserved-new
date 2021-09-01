<?php

namespace App\Domain\Repositories\OrganizationRequest;

use App\Models\OrganizationRequest;
use Illuminate\Support\Facades\DB;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationRequestContract;

class OrganizationRequestRepositoryEloquent implements OrganizationRequestRepositoryInterface
{
    public function create($data)
    {
        return OrganizationRequest::create($data);
    }

    public function getByPhone($phone)
    {
        return DB::table(OrganizationRequestContract::TABLE)
            ->where([
                [MainContract::PHONE,$phone],
                [MainContract::STATUS,'!=',MainContract::REJECTED]
            ])
            ->first();
    }

}
