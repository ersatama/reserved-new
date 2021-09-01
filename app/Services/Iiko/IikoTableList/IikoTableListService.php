<?php


namespace App\Services\Iiko\IikoTableList;

use App\Services\BaseService;

use App\Domain\Repositories\Iiko\IikoTableList\IikoTableListRepositoryInterface;

class IikoTableListService extends BaseService
{
    protected $iikoTableListRepository;
    public function __construct(IikoTableListRepositoryInterface $iikoTableListRepository)
    {
        $this->iikoTableListRepository  =   $iikoTableListRepository;
    }

    public function create($data)
    {
        return $this->iikoTableListRepository->create($data);
    }
}
