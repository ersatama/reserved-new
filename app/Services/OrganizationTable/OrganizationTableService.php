<?php


namespace App\Services\OrganizationTable;

use App\Services\BaseService;
use App\Domain\Repositories\OrganizationTable\OrganizationTableRepositoryInterface;

class OrganizationTableService
{
    protected $organizationTableRepository;
    public function __construct(OrganizationTableRepositoryInterface $organizationTableRepository)
    {
        $this->organizationTableRepository  =   $organizationTableRepository;
    }

    public function getByOrganizationId($id) {
        return $this->organizationTableRepository->getByOrganizationId($id);
    }

    public function getById($id)
    {
        return $this->organizationTableRepository->getById($id);
    }

    public function create($data)
    {
        return $this->organizationTableRepository->create($data);
    }

    public function update($id,$data)
    {
        $this->organizationTableRepository->update($id,$data);
    }

}
