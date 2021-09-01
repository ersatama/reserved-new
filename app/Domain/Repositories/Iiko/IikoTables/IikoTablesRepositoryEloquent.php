<?php


namespace App\Domain\Repositories\Iiko\IikoTables;

use App\Models\IikoTables;

class IikoTablesRepositoryEloquent implements IikoTablesRepositoryInterface
{
    public function create($data)
    {
        return IikoTables::create($data);
    }
}
