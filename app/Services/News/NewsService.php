<?php

namespace App\Services\News;

use App\Domain\Repositories\News\NewsRepositoryInterface;

class NewsService
{
    protected $newsRepository;
    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository   =   $newsRepository;
    }

    public function create($data)
    {
        return $this->newsRepository->create($data);
    }

    public function update($id, $data)
    {
        $this->newsRepository->update($id, $data);
    }

    public function list($page)
    {
        return $this->newsRepository->list($page);
    }

    public function getByOrganizationId($organizationId)
    {
        return $this->newsRepository->getByOrganizationId($organizationId);
    }

    public function getByOrganizationIdAndStatus($organizationId, $status)
    {
        return $this->newsRepository->getByOrganizationIdAndStatus($organizationId, $status);
    }

    public function getById($id)
    {
        return $this->newsRepository->getById($id);
    }

    public function getByIdAndStatus($id, $status)
    {
        return $this->newsRepository->getByIdAndStatus($id, $status);
    }

}
