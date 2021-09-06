<?php


namespace App\Services\Category;

use App\Services\BaseService;
use App\Domain\Repositories\Category\CategoryRepositoryInterface;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository   =   $categoryRepository;
    }

    public function list()
    {
        return $this->categoryRepository->list();
    }

    public function getBySlug($slug)
    {
        return $this->categoryRepository->getBySlug($slug);
    }

    public function getById($id)
    {
        return $this->categoryRepository->getById($id);
    }
}
