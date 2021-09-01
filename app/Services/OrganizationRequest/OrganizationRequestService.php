<?php

namespace App\Services\OrganizationRequest;

use App\Services\BaseService;
use App\Domain\Repositories\OrganizationRequest\OrganizationRequestRepositoryInterface;

class OrganizationRequestService extends BaseService
{
    protected $organizationRequestRepository;
    public function __construct(OrganizationRequestRepositoryInterface $organizationRequestRepository)
    {
        $this->organizationRequestRepository    =   $organizationRequestRepository;
    }

    public function create($data)
    {
        return $this->organizationRequestRepository->create($data);
    }

    public function getByPhone($phone)
    {
        return $this->organizationRequestRepository->getByPhone($phone);
    }

}
