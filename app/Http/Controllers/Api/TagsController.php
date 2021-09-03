<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Tags\TagsService;

class TagsController extends Controller
{
    protected $tagsService;
    public function __construct(TagsService $tagsService)
    {
        $this->tagsService  =   $tagsService;
    }

    public function list()
    {
        return $this->tagsService->list();
    }
}
