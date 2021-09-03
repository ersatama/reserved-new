<?php

namespace App\Services\TagsOptionOrganization;

use App\Domain\Repositories\TagsOptionOrganization\TagsOptionOrganizationRepositoryInterface;
use Illuminate\Support\Collection;

class TagsOptionOrganizationService
{
    protected $optionOrganizationRepository;
    public function __construct(TagsOptionOrganizationRepositoryInterface $optionOrganizationRepository)
    {
        $this->optionOrganizationRepository =   $optionOrganizationRepository;
    }

    public function update($data)
    {
        $this->optionOrganizationRepository->update($data);
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->optionOrganizationRepository->getByOrganizationId($organizationId);
    }

}
