<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationTablesContract;

use Illuminate\Http\Request;
use App\Http\Requests\Organization\OrganizationIdsRequest;
use App\Http\Requests\Organization\OrganizationUpdateRequest;

use App\Http\Controllers\Controller;

use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationTablesCollection;
use App\Models\OrganizationTables;

use App\Services\Organization\OrganizationService;
use App\Services\OrganizationTableList\OrganizationTableListService;
use App\Services\Booking\BookingService;
use Illuminate\Validation\ValidationException;

class OrganizationController extends Controller
{

    protected $paginate =   1;
    protected $organizationService;
    protected $organizationTableListService;
    protected $bookingService;

    public function __construct(OrganizationService $organizationService, OrganizationTableListService $organizationTableListService, BookingService $bookingService) {
        $this->organizationService  =   $organizationService;
        $this->organizationTableListService =   $organizationTableListService;
        $this->bookingService   =   $bookingService;
    }

    /**
     * @throws ValidationException
     */
    public function update($id, OrganizationUpdateRequest $organizationUpdateRequest):void
    {
        $this->organizationService->update($id, $organizationUpdateRequest->validated());
    }


    public function status($id,$date): object
    {
        $tables =   $this->organizationTableListService->getByOrganizationId($id);
        foreach ($tables as &$table) {
            $table->bookingStatus   =   $this->bookingService->getLastByTableId($table->id,$date);
        }
        return $tables;
    }

    /**
     * @throws ValidationException
     */
    public function getByIds(OrganizationIdsRequest $organizationIdsRequest): OrganizationCollection
    {
        $data   =   $organizationIdsRequest->validated();
        return new OrganizationCollection($this->organizationService->getByIds($data[MainContract::IDS]));
    }

    public function list(Request $request): OrganizationCollection
    {
        if ($request->has('paginate')) {
            $this->paginate =   (int)$request->input('paginate');
        }
        return new OrganizationCollection($this->organizationService->list($this->paginate));
    }

    public function search($search, Request $request): OrganizationCollection
    {
        if ($request->has('paginate')) {
            $this->paginate =   (int)$request->input('paginate');
        }
        return new OrganizationCollection($this->organizationService->search($search,$this->paginate));
    }

    public function getSectionsById($id): OrganizationTablesCollection
    {
        return new OrganizationTablesCollection(OrganizationTables::with('organizationTables')->where(MainContract::ORGANIZATION_ID,$id)->get());
    }

    public function getByCategoryId($id, Request $request): OrganizationCollection
    {
        if ($request->has('paginate')) {
            $this->paginate =   (int)$request->input('paginate');
        }
        return new OrganizationCollection($this->organizationService->getByCategoryId($id,$this->paginate));
    }

    public function getByCategoryIdAndCityId($id, $cityId, Request $request): OrganizationCollection
    {
        if ($request->has('paginate')) {
            $this->paginate =   (int)$request->input('paginate');
        }
        return new OrganizationCollection($this->organizationService->getByCategoryIdAndCityId($id, $cityId, $this->paginate));
    }

    public function getById($id)
    {
        $organization   =   $this->organizationService->getById($id);
        if ($organization) {
            return new OrganizationResource($organization);
        }
        return response(['message'  =>  'Организация не найдено'],404);
    }

    public function getByUserId($userId): OrganizationResource
    {
        return new OrganizationResource($this->organizationService->getByUserId($userId));
    }

}
