<?php


namespace App\Services\City;

use App\Services\BaseService;
use App\Domain\Repositories\City\CityRepositoryInterface as CityRepository;

class CityService extends BaseService
{
    protected $cityRepository;
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository   =   $cityRepository;
    }


}
