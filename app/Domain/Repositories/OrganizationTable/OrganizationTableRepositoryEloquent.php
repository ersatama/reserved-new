<?php


namespace App\Domain\Repositories\OrganizationTable;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationTablesContract;
use App\Models\OrganizationTables;
use Illuminate\Support\Facades\DB;

class OrganizationTableRepositoryEloquent implements OrganizationTableRepositoryInterface
{
    public function create($data)
    {
        return OrganizationTables::create($data);
    }

    public function update($id,$data)
    {
        DB::table(OrganizationTablesContract::TABLE)
            ->where(MainContract::ID,$id)
            ->update($data);
    }

    public function getByOrganizationId($id) {
        return OrganizationTables::where([
            [MainContract::ORGANIZATION_ID,$id],
            [MainContract::STATUS,'!=', MainContract::DISABLED]
        ])->get();
    }

    public function getById($id)
    {
        return OrganizationTables::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,'!=',MainContract::DISABLED]
        ])->first();
    }
}
