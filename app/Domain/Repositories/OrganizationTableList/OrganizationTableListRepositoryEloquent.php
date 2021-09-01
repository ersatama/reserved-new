<?php


namespace App\Domain\Repositories\OrganizationTableList;

use App\Domain\Contracts\MainContract;
use App\Models\OrganizationTableList;

class OrganizationTableListRepositoryEloquent implements OrganizationTableListRepositoryInterface
{
    public function create(array $data)
    {
        return OrganizationTableList::create($data);
    }

    public function update($id, $data)
    {
        OrganizationTableList::where(MainContract::ID,$id)->update($data);
    }

    public function getById($id)
    {
        return OrganizationTableList::with('organization','organizationTable')->where([
            [MainContract::ID,$id],
            [MainContract::STATUS,'!=', MainContract::DISABLED]
        ])->first();
    }

    public function getByTableId($id):object
    {
        return OrganizationTableList::with('organization','organizationTable')->where([
            [MainContract::ORGANIZATION_TABLE_ID,$id],
            [MainContract::STATUS,'!=', MainContract::DISABLED]
        ])->get();
    }

    public function getByOrganizationId($id):object
    {
        return OrganizationTableList::with('organizationTable')->where([
            [MainContract::ORGANIZATION_ID,$id],
            [MainContract::STATUS,'!=', MainContract::DISABLED]
        ])->get();
    }
}
