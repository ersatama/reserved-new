<?php

namespace App\Services\NewsImage;

use App\Domain\Repositories\NewsImage\NewsImageRepositoryInterface;
use Illuminate\Support\Collection;

class NewsImageService
{
    protected $newsImageRepository;
    public function __construct(NewsImageRepositoryInterface $newsImageRepository)
    {
        $this->newsImageRepository  =   $newsImageRepository;
    }

    public function create($data)
    {
        return $this->newsImageRepository->create($data);
    }

    public function update($id, $data)
    {
        $this->newsImageRepository->update($id, $data);
    }

    public function getByNewsId($newsId): Collection
    {
        return $this->newsImageRepository->getByNewsId($newsId);
    }

    public function getById($id)
    {
        return $this->newsImageRepository->getById($id);
    }

}
