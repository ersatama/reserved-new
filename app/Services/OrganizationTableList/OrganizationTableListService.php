<?php


namespace App\Services\OrganizationTableList;

use App\Services\BaseService;
use App\Domain\Repositories\OrganizationTableList\OrganizationTableListRepositoryInterface;

class OrganizationTableListService extends BaseService
{
    protected $organizationTableListRepository;

    public function __construct(OrganizationTableListRepositoryInterface $organizationTableListRepository)
    {
        $this->organizationTableListRepository  =   $organizationTableListRepository;
    }

    public function create($data)
    {
        return $this->organizationTableListRepository->create($data);
    }

    public function update($id, array $data):void
    {
        $this->organizationTableListRepository->update($id, $data);
    }

    public function getById($id)
    {
        return $this->organizationTableListRepository->getById($id);
    }

    public function getByTableId($id): object
    {
        return $this->organizationTableListRepository->getByTableId($id);
    }

    public function getByOrganizationId($id): object
    {
        return $this->organizationTableListRepository->getByOrganizationId($id);
    }
}
