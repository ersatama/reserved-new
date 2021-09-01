<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Language\LanguagesService;

use App\Http\Resources\Language\LanguageCollection;

class LanguageController extends Controller
{
    protected $languagesService;
    public function __construct(LanguagesService $languagesService)
    {
        $this->languagesService =   $languagesService;
    }

    public function list()
    {
        return new LanguageCollection($this->languagesService->list());
    }
}
