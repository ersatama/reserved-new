<?php


namespace App\Services\Country;

use App\Services\BaseService;
use App\Domain\Repositories\Country\CountryRepositoryInterface;

class CountryService extends BaseService
{
    protected $countryRepository;
    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository    =   $countryRepository;
    }

    public function list()
    {
        return $this->countryRepository->list();
    }
}
