<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TagsOption\TagsOptionService;
use Illuminate\Support\Collection;

class TagsOptionController extends Controller
{
    protected $tagsOptionService;
    public function __construct(TagsOptionService $tagsOptionService)
    {
        $this->tagsOptionService    =   $tagsOptionService;
    }

    public function other(): Collection
    {
        return $this->tagsOptionService->other();
    }
}
