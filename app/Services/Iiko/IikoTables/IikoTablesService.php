<?php


namespace App\Services\Iiko\IikoTables;

use App\Services\BaseService;
use App\Domain\Repositories\Iiko\IikoTables\IikoTablesRepositoryInterface;

class IikoTablesService extends BaseService
{
    protected $iikoTablesRepository;
    public function __construct(IikoTablesRepositoryInterface $iikoTablesRepository)
    {
        $this->iikoTablesRepository =   $iikoTablesRepository;
    }

    public function create($data)
    {
        return $this->iikoTablesRepository->create($data);
    }

}
