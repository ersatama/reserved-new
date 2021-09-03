<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TagsOptionOrganization\TagsOptionOrganizationService;
use App\Http\Requests\TagsOptionOrganization\TagsOptionOrganizationUpdateRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TagsOptionOrganizationController extends Controller
{
    protected $optionOrganizationService;
    public function __construct(TagsOptionOrganizationService $optionOrganizationService)
    {
        $this->optionOrganizationService    =   $optionOrganizationService;
    }

    /**
     * @throws ValidationException
     */
    public function update(TagsOptionOrganizationUpdateRequest $tagsOptionOrganizationUpdateRequest)
    {
        $this->optionOrganizationService->update($tagsOptionOrganizationUpdateRequest->validated());
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->optionOrganizationService->getByOrganizationId($organizationId);
    }

}
