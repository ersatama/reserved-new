<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Services\Category\CategoryService;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService  =   $categoryService;
    }

    public function list(): CategoryCollection
    {
        return new CategoryCollection($this->categoryService->list());
    }

    public function getBySlug($slug)
    {
        if ($category = $this->categoryService->getBySlug($slug)) {
            return new CategoryResource($category);
        }
        return response(['message'  =>  'Категория не найдена'],404);
    }
}
