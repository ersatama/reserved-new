<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\OrganizationImage\OrganizationImageService;

use App\Http\Resources\OrganizationImage\OrganizationImageCollection;
use App\Http\Resources\OrganizationImage\OrganizationImageResource;

use App\Http\Requests\OrganizationImage\OrganizationImageCreateRequest;
use App\Http\Requests\OrganizationImage\OrganizationImageUpdateRequest;

use Illuminate\Validation\ValidationException;

class OrganizationImageController extends Controller
{
    protected $organizationImageService;
    public function __construct(OrganizationImageService $organizationImageService)
    {
        $this->organizationImageService =   $organizationImageService;
    }

    public function getByOrganizationId($organizationId): OrganizationImageCollection
    {
        return new OrganizationImageCollection($this->organizationImageService->getByOrganizationId($organizationId));
    }

    /**
     * @throws ValidationException
     */
    public function create(OrganizationImageCreateRequest $organizationImageCreateRequest): OrganizationImageResource
    {
        return new OrganizationImageResource($this->organizationImageService->create($organizationImageCreateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, OrganizationImageUpdateRequest $organizationImageUpdateRequest):void
    {
        $this->organizationImageService->update($id, $organizationImageUpdateRequest->validated());
    }

}
