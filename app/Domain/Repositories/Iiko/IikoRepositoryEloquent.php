<?php


namespace App\Domain\Repositories\Iiko;

use App\Domain\Contracts\IikoContract;
use App\Models\Iiko;

class IikoRepositoryEloquent implements IikoRepositoryInterface
{

    public function getById($id)
    {
        return Iiko::where([
            [IikoContract::ID,$id],
            [IikoContract::STATUS,IikoContract::ENABLED]
        ])->first();
    }

    public function getByOrganizationId($organizationId)
    {
        return Iiko::where([
            [IikoContract::ORGANIZATION_ID,$organizationId],
            [IikoContract::STATUS,IikoContract::ENABLED]
        ])->get();
    }

}
