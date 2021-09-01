<?php

namespace App\Domain\Repositories\OrganizationImage;

use App\Domain\Contracts\MainContract;
use App\Models\OrganizationImage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Domain\Contracts\OrganizationImageContract;

class OrganizationImageRepositoryEloquent implements OrganizationImageRepositoryInterface
{
    public function getByOrganizationId($organizationId): Collection
    {
        return DB::table(OrganizationImageContract::TABLE)->where([
            [MainContract::ORGANIZATION_ID,$organizationId],
            [MainContract::STATUS,MainContract::ON]
        ])->get();
    }

    public function create($data)
    {
        return OrganizationImage::create($data);
    }

    public function update($id, $data):void
    {
        DB::table(OrganizationImageContract::TABLE)
            ->where(MainContract::ID,$id)
            ->update($data);
    }

}
