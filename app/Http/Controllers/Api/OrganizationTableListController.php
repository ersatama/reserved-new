<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;

use App\Services\OrganizationTableList\OrganizationTableListService;

use App\Http\Requests\OrganizationTableList\OrganizationTableListUpdateRequest;
use App\Http\Requests\OrganizationTableList\OrganizationTableListCreateRequest;
use App\Http\Requests\OrganizationTableList\OrganizationTableListArrayRequest;

use Illuminate\Validation\ValidationException;

use App\Http\Resources\OrganizationTableList\OrganizationTableListResource;
use App\Http\Resources\OrganizationTableList\OrganizationTableListCollection;

class OrganizationTableListController extends Controller
{
    protected $organizationTableListService;

    public function __construct(OrganizationTableListService $organizationTableListService)
    {
        $this->organizationTableListService =   $organizationTableListService;
    }

    /**
     * @throws ValidationException
     */
    public function array(OrganizationTableListArrayRequest $organizationTableListArrayRequest)
    {
        $data   =   $organizationTableListArrayRequest->validated();
        foreach ($data[MainContract::TABLES] as &$table) {
            $this->organizationTableListService->create([
                MainContract::ORGANIZATION_ID   =>  $data[MainContract::ORGANIZATION_ID],
                MainContract::ORGANIZATION_TABLE_ID   =>  $data[MainContract::ORGANIZATION_TABLE_ID],
                MainContract::TITLE =>  $table[MainContract::TITLE],
                MainContract::LIMIT =>  $table[MainContract::LIMIT],
                MainContract::PRICE =>  $table[MainContract::PRICE],
                MainContract::STATUS    =>  $table[MainContract::STATUS],
            ]);
        }
        return new OrganizationTableListCollection($this->organizationTableListService->getByTableId($data[MainContract::ORGANIZATION_TABLE_ID]));
    }

    /**
     * @throws ValidationException
     */
    public function create(OrganizationTableListCreateRequest $organizationTableListCreateRequest): OrganizationTableListResource
    {
        return new OrganizationTableListResource($this->organizationTableListService->create($organizationTableListCreateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, OrganizationTableListUpdateRequest $organizationTableListUpdateRequest):void
    {
        $this->organizationTableListService->update($id, $organizationTableListUpdateRequest->validated());
    }

    public function getById($id)
    {
        if ($table = $this->organizationTableListService->getById($id)) {
            return new OrganizationTableListResource($table);
        }
        return response([MainContract::MESSAGE => 'Организация не найдено'],404);
    }

    public function getByTableId($tableId): OrganizationTableListCollection
    {
        return new OrganizationTableListCollection($this->organizationTableListService->getByTableId($tableId));
    }

    public function getByOrganizationId($organizationId): OrganizationTableListCollection
    {
        return new OrganizationTableListCollection($this->organizationTableListService->getByOrganizationId($organizationId));
    }

}
