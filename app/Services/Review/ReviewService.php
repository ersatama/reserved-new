<?php


namespace App\Services\Review;

use App\Services\BaseService;
use App\Domain\Repositories\Review\ReviewRepositoryInterface as ReviewRepository;

class ReviewService extends BaseService
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository) {
        $this->reviewRepository =   $reviewRepository;
    }

    public function create($data)
    {
        return $this->reviewRepository->create($data);
    }

    public function update(int $id,array $data)
    {
        return $this->reviewRepository->update($id,$data);
    }

    public function delete(int $id):void {
        $this->reviewRepository->delete($id);
    }

    public function getById(int $id) {
        return $this->reviewRepository->getById($id);
    }

    public function getCountByOrganizationId($organizationId)
    {
        return $this->reviewRepository->getCountByOrganizationId($organizationId);
    }

    public function getByOrganizationId(int $id,$paginate) {
        return $this->reviewRepository->getByOrganizationId($id,$paginate);
    }

    public function getByUserId(int $id,$paginate) {
        return $this->reviewRepository->getByUserId($id,$paginate);
    }

    public function getGroupByOrganizationId($organizationId)
    {
        return $this->reviewRepository->getGroupByOrganizationId($organizationId);
    }

}
