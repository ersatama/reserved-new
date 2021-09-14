<?php

namespace App\Services\NewsSubscribe;

use App\Domain\Contracts\MainContract;
use App\Domain\Repositories\NewsSubscribe\NewsSubscribeRepositoryInterface;
use Illuminate\Support\Collection;

class NewsSubscribeService
{
    protected $newsSubscribeRepository;
    public function __construct(NewsSubscribeRepositoryInterface $newsSubscribeRepository)
    {
        $this->newsSubscribeRepository  =   $newsSubscribeRepository;
    }

    public function create($data)
    {
        return $this->newsSubscribeRepository->create($data);
    }

    public function update($id, $data)
    {
        $this->newsSubscribeRepository->update($id, $data);
    }

    public function getByUserId($userId): Collection
    {
        return $this->newsSubscribeRepository->getByUserId($userId);
    }

    public function getOrganizationIdsByUserId($userId): array
    {
        $organizations  =   $this->getByUserId($userId);
        $ids    =   [];
        foreach ($organizations as &$organization) {
            $ids[]  =   $organization->{MainContract::ORGANIZATION_ID};
        }
        return $ids;
    }

    public function getByOrganizationIdAndUserId($organizationId, $userId)
    {
        return $this->newsSubscribeRepository->getByOrganizationIdAndUserId($organizationId, $userId);
    }
}
