<?php

namespace App\Services\OrganizationImage;

use App\Domain\Repositories\OrganizationImage\OrganizationImageRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationImageService
{
    protected $organizationImageRepository;
    public function __construct(OrganizationImageRepositoryInterface $organizationImageRepository)
    {
        $this->organizationImageRepository  =   $organizationImageRepository;
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->organizationImageRepository->getByOrganizationId($organizationId);
    }

    public function create($data)
    {
        return $this->organizationImageRepository->create($data);
    }

    public function update($id, $data):void
    {
        $this->organizationImageRepository->update($id, $data);
    }

}
