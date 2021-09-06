<?php


namespace App\Services\Organization;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationContract;
use App\Services\BaseService;
use App\Domain\Repositories\Organization\OrganizationRepositoryInterface;
use App\Domain\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationService
{
    protected $organizationRepository;
    protected $reviewRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository, ReviewRepositoryInterface $reviewRepository)
    {
        $this->organizationRepository   =   $organizationRepository;
        $this->reviewRepository         =   $reviewRepository;
    }

    public function updateRating($id):void
    {
        $average    =   $this->reviewRepository->sumRating($id);
        $this->organizationRepository->updateRating($id,$average);
    }

    public function update($id,$data)
    {
        $this->organizationRepository->update($id,$data);
    }

    public function getByIds($ids)
    {
        return $this->organizationRepository->getByIds($ids);
    }

    public function list(int $paginate)
    {
        return $this->organizationRepository->list($paginate);
    }

    public function search(string $search, int $paginate)
    {
        return $this->organizationRepository->searchByTitle($search,$paginate);
    }

    public function getById($id)
    {
        return $this->organizationRepository->getById($id);
    }

    public function getByCategoryId($id, int $paginate)
    {
        return $this->organizationRepository->getByCategoryId($id,$paginate);
    }

    public function getByCategoryIdAndCityId($id, $cityId, $paginate)
    {
        return $this->organizationRepository->getByCategoryIdAndCityId($id, $cityId, $paginate);
    }

    public function getByUserId(int $id)
    {
        return $this->organizationRepository->getByUserId($id);
    }

    public function getIdsByUserId($userId): array
    {
        return $this->clearArray($this->organizationRepository->getIdsByUserId($userId), MainContract::ID);
    }

    public function clearArray($array, $key): array
    {
        $arr    =   [];
        foreach ($array as &$value) {
            $arr[]  =   $value[$key];
        }
        return $arr;
    }

    public function getMinAndMaxPrice(): Collection
    {
        return $this->organizationRepository->getMinAndMaxPrice();
    }
}
