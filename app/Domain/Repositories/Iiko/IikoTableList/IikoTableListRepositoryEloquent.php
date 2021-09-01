<?php


namespace App\Domain\Repositories\Iiko\IikoTableList;

use App\Models\IikoTableList;

class IikoTableListRepositoryEloquent implements IikoTableListRepositoryInterface
{
    public function create($data)
    {
        return IikoTableList::create($data);
    }
}
