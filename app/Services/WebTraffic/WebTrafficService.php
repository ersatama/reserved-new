<?php

namespace App\Services\WebTraffic;

use App\Domain\Repositories\WebTraffic\WebTrafficRepositoryInterface;
use Illuminate\Support\Collection;

class WebTrafficService
{
    protected $webTrafficRepository;
    public function __construct(WebTrafficRepositoryInterface $webTrafficRepository)
    {
        $this->webTrafficRepository =   $webTrafficRepository;
    }

    public function create($data)
    {
        return $this->webTrafficRepository->create($data);
    }

    public function getByOrganizationIdAndDate($organizationId, $date): Collection
    {
        return $this->webTrafficRepository->getByOrganizationIdAndDate($organizationId,$date);
    }

    public function getByBetweenDateAndOrganizationId($start, $end, $organization): Collection
    {
        return $this->webTrafficRepository->getByBetweenDateAndOrganizationId($start, $end, $organization);
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->webTrafficRepository->getByOrganizationId($organizationId);
    }

    public function getByDateAndOrganizationIdAndIpAndWeb($date,$organizationId,$ip,$website)
    {
        return $this->webTrafficRepository->getByDateAndOrganizationIdAndIpAndWeb($date,$organizationId,$ip,$website);
    }

    public function getRealIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip =   $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip =   $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip =   $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getReferer()
    {
        $url    =   'reserved-app.kz';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url    =   parse_url($_SERVER['HTTP_REFERER'],PHP_URL_HOST);
        }
        return $url;
    }
}
