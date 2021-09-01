<?php


namespace App\Services\Iiko;

use App\Services\BaseService;

use App\Domain\Repositories\Iiko\IikoRepositoryInterface;

class IikoService extends BaseService
{
    protected $iikoRepository;
    public function __construct(IikoRepositoryInterface $iikoRepository)
    {
        $this->iikoRepository   =   $iikoRepository;
    }

    public function getById($id)
    {
        return $this->iikoRepository->getById($id);
    }

    public function getByOrganizationId($organizationId)
    {
        return $this->iikoRepository->getByOrganizationId($organizationId);
    }

}
