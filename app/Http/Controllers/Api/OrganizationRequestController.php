<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Services\OrganizationRequest\OrganizationRequestService;
use App\Http\Requests\OrganizationRequest\OrganizationRequestCreateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\OrganizationRequest\OrganizationRequestResource;

class OrganizationRequestController extends Controller
{
    protected $organizationRequestService;
    protected $userService;
    public function __construct(OrganizationRequestService $organizationRequestService)
    {
        $this->organizationRequestService   =   $organizationRequestService;
    }

    /**
     * @throws ValidationException
     */
    public function create(OrganizationRequestCreateRequest $organizationRequestCreateRequest): OrganizationRequestResource
    {
        return new OrganizationRequestResource($this->organizationRequestService->create($organizationRequestCreateRequest->validated()));
    }

    public function getByPhone($phone)
    {
        if ($organizationRequest = $this->organizationRequestService->getByPhone($phone)) {
            return new OrganizationRequestResource($organizationRequest);
        }
        return response(['message'  =>  'Заявка не найдена'],404);
    }

}
