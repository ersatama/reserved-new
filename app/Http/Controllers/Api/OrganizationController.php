<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationContract;
use App\Domain\Contracts\OrganizationTablesContract;
use App\Domain\Contracts\TagsOptionContract;
use App\Domain\Contracts\TagsOptionOrganizationContract;
use Illuminate\Http\Request;
use App\Http\Requests\Organization\OrganizationIdsRequest;
use App\Http\Requests\Organization\OrganizationUpdateRequest;
use App\Http\Requests\Organization\OrganizationFilterRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationTablesCollection;
use App\Models\OrganizationTables;
use App\Services\Organization\OrganizationService;
use App\Services\OrganizationTableList\OrganizationTableListService;
use App\Services\Booking\BookingService;
use App\Services\Tags\TagsService;
use App\Services\TagsOption\TagsOptionService;
use App\Services\Category\CategoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrganizationController extends Controller
{

    protected $paginate =   1;
    protected $take     =   15;
    protected $organizationService;
    protected $organizationTableListService;
    protected $bookingService;
    protected $tagsService;
    protected $tagsOptionService;
    protected $categoryService;

    public function __construct(OrganizationService $organizationService, OrganizationTableListService $organizationTableListService, BookingService $bookingService, TagsService $tagsService, TagsOptionService $tagsOptionService, CategoryService $categoryService) {
        $this->organizationService  =   $organizationService;
        $this->organizationTableListService =   $organizationTableListService;
        $this->bookingService   =   $bookingService;
        $this->tagsService  =   $tagsService;
        $this->tagsOptionService    =   $tagsOptionService;
        $this->categoryService  =   $categoryService;
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

    public function getCountByCategoryIdAndCityIdAndFilter($id, $cityId, $page, OrganizationFilterRequest $organizationFilterRequest)
    {
        $data   =   $organizationFilterRequest->validated();
        $sql    =   DB::table(OrganizationContract::TABLE)
            ->select(OrganizationContract::TABLE.'.*');
        if (array_key_exists(MainContract::TAGS, $data) && sizeof($data[MainContract::TAGS]) > 0) {

            $sql->join(TagsOptionOrganizationContract::TABLE, TagsOptionOrganizationContract::TABLE.'.'.MainContract::ORGANIZATION_ID, '=', OrganizationContract::TABLE.'.'.MainContract::ID);
            $sql->whereIn(TagsOptionOrganizationContract::TABLE.'.'.MainContract::TAGS_OPTION_ID, $data[MainContract::TAGS]);

        }

        if (array_key_exists(MainContract::PRICE, $data) && $data[MainContract::PRICE][MainContract::STATUS]) {
            if ((int) $data[MainContract::PRICE][MainContract::MAX] === 0) {
                $sql->where(OrganizationContract::TABLE.'.'.MainContract::PRICE,'>=',$data[MainContract::PRICE][MainContract::MIN]);
            } else {
                $sql->whereBetween(MainContract::PRICE,[
                    $data[MainContract::PRICE][MainContract::MIN],
                    $data[MainContract::PRICE][MainContract::MAX]
                ]);
            }
        }

        if (array_key_exists(MainContract::RATINGS, $data) &&  $data[MainContract::RATINGS][MainContract::STATUS]) {
            $sql->whereBetween(MainContract::RATING,[
                $data[MainContract::RATINGS][MainContract::MIN],
                $data[MainContract::RATINGS][MainContract::MAX]
            ]);
        }

        $sql->where([
            [OrganizationContract::TABLE.'.'.MainContract::CATEGORY_ID,'=',$id],
            [OrganizationContract::TABLE.'.'.MainContract::CITY_ID,'=',$cityId],
        ]);

        return $sql->count();
    }

    /**
     * @throws ValidationException
     */
    public function getByCategoryIdAndCityIdAndFilter($id, $cityId, $page, OrganizationFilterRequest $organizationFilterRequest): OrganizationCollection
    {
        $data   =   $organizationFilterRequest->validated();
        $sql    =   DB::table(OrganizationContract::TABLE)
            ->select(OrganizationContract::TABLE.'.*');
        if (array_key_exists(MainContract::TAGS, $data) && sizeof($data[MainContract::TAGS]) > 0) {

            $sql->join(TagsOptionOrganizationContract::TABLE, TagsOptionOrganizationContract::TABLE.'.'.MainContract::ORGANIZATION_ID, '=', OrganizationContract::TABLE.'.'.MainContract::ID);
            $sql->whereIn(TagsOptionOrganizationContract::TABLE.'.'.MainContract::TAGS_OPTION_ID, $data[MainContract::TAGS]);

        }

        if (array_key_exists(MainContract::PRICE, $data) && $data[MainContract::PRICE][MainContract::STATUS]) {
            if ((int) $data[MainContract::PRICE][MainContract::MAX] === 0) {
                $sql->where(OrganizationContract::TABLE.'.'.MainContract::PRICE,'>=',$data[MainContract::PRICE][MainContract::MIN]);
            } else {
                $sql->whereBetween(MainContract::PRICE,[
                    $data[MainContract::PRICE][MainContract::MIN],
                    $data[MainContract::PRICE][MainContract::MAX]
                ]);
            }
        }

        if (array_key_exists(MainContract::RATINGS, $data) &&  $data[MainContract::RATINGS][MainContract::STATUS]) {
            $sql->whereBetween(MainContract::RATING,[
                $data[MainContract::RATINGS][MainContract::MIN],
                $data[MainContract::RATINGS][MainContract::MAX]
            ]);
        }

        $sql->where([
            [OrganizationContract::TABLE.'.'.MainContract::CATEGORY_ID,'=',$id],
            [OrganizationContract::TABLE.'.'.MainContract::CITY_ID,'=',$cityId],
        ]);
        if (array_key_exists(MainContract::SORT,$data)) {
            if ((int)$data[MainContract::SORT] === 0) {
                $sql->orderBy(MainContract::RATING,MainContract::DESC);
            } elseif ((int)$data[MainContract::SORT] === 1) {
                $sql->orderBy(MainContract::PRICE,MainContract::DESC);
            } elseif ((int)$data[MainContract::SORT] === 2) {
                $sql->orderBy(MainContract::PRICE);
            } else {
                $sql->orderBy(MainContract::RATING,MainContract::DESC);
            }
        } else {
            $sql->orderBy(MainContract::RATING,MainContract::DESC);
        }
        $organizations  =   $sql->skip( ($page - 1) * $this->take)
            ->take($this->take)
            ->get();

        foreach ($organizations as &$organization) {
            $organization->{MainContract::CATEGORY} =   $this->categoryService->getById($organization->{MainContract::CATEGORY_ID});
        }
        return new OrganizationCollection($organizations);
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

    public function find($search): OrganizationCollection
    {
        return new OrganizationCollection($this->organizationService->find($search));
    }

    public function getByTag($tag)
    {
        $tag    =   $this->tagsOptionService->getByTitle($tag);
        return $tag;
    }

    public function filter(): array
    {
        return [
            MainContract::TAGS_ID   =>  $this->tagsService->list(),
            MainContract::TAGS_OPTION_ID    =>  $this->tagsOptionService->other()
        ];
    }

}
