<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Services\OrganizationTable\OrganizationTableService;
use App\Http\Resources\OrganizationTablesCollection;
use App\Http\Requests\OrganizationTable\OrganizationTableCreateRequest;
use App\Http\Requests\OrganizationTable\OrganizationTableUpdateRequest;
use Illuminate\Validation\ValidationException;

class OrganizationTableController extends Controller
{
    protected $organizationTableService;
    public function __construct(OrganizationTableService $organizationTableService)
    {
        $this->organizationTableService =   $organizationTableService;
    }

    public function getByOrganizationId($organizationId): OrganizationTablesCollection
    {
        return new OrganizationTablesCollection($this->organizationTableService->getByOrganizationId($organizationId));
    }

    /**
     * @throws ValidationException
     */
    public function create(OrganizationTableCreateRequest $organizationTableCreateRequest): OrganizationTablesCollection
    {
        $data   =   $organizationTableCreateRequest->validated();
        foreach ($data[MainContract::SECTIONS] as &$value) {
            $this->organizationTableService->create([
                MainContract::ORGANIZATION_ID   =>  $data[MainContract::ORGANIZATION_ID],
                MainContract::NAME  =>  $value[MainContract::NAME],
                MainContract::STATUS    =>  $value[MainContract::STATUS],
            ]);
        }
        return new OrganizationTablesCollection($this->organizationTableService->getByOrganizationId($data[MainContract::ORGANIZATION_ID]));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, OrganizationTableUpdateRequest $organizationTableUpdateRequest)
    {
        $this->organizationTableService->update($id, $organizationTableUpdateRequest->validated());
    }

}
