<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Country\CountryService;
use App\Http\Resources\CountryCollection;

class CountryController extends Controller
{
    protected $countryService;
    public function __construct(CountryService $countryService)
    {
        $this->countryService   =   $countryService;
    }

    public function list()
    {
        return new CountryCollection($this->countryService->list());
    }
}
