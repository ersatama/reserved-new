<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WebTraffic\WebTrafficService;
use App\Http\Requests\WebTraffic\WebTrafficCreateRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class WebTrafficController extends Controller
{
    protected $webTrafficService;
    public function __construct(WebTrafficService $webTrafficService)
    {
        $this->webTrafficService    =   $webTrafficService;
    }

    /**
     * @throws ValidationException
     */
    public function create(WebTrafficCreateRequest $webTrafficCreateRequest)
    {
        return $this->webTrafficService->create($webTrafficCreateRequest->validated());
    }

    public function getByOrganizationIdAndDate($organization, $date): Collection
    {
        return $this->webTrafficService->getByOrganizationIdAndDate($organization,$date);
    }

    public function getByBetweenDateAndOrganizationId($start, $end, $organization): Collection
    {
        return $this->webTrafficService->getByBetweenDateAndOrganizationId($start, $end, $organization);
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->webTrafficService->getByOrganizationId($organizationId);
    }

    public function getByDateAndOrganizationIdAndIpAndWeb($date,$organizationId,$ip,$website)
    {
        return $this->webTrafficService->getByDateAndOrganizationIdAndIpAndWeb($date,$organizationId,$ip,$website);
    }
}
