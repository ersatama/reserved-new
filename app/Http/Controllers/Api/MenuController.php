<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuCreateRequest;
use App\Http\Requests\Menu\MenuUpdateRequest;
use App\Services\Menu\MenuService;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Menu\MenuCollection;
use App\Http\Resources\Menu\MenuResource;

class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService  =   $menuService;
    }

    public function getByOrganizationId($organizationId): MenuCollection
    {
        return new MenuCollection($this->menuService->getByOrganizationId($organizationId));
    }

    /**
     * @throws ValidationException
     */
    public function create(MenuCreateRequest $menuCreateRequest): MenuResource
    {
        return new MenuResource($this->menuService->create($menuCreateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, MenuUpdateRequest $menuUpdateRequest):void
    {
        $this->menuService->update($id, $menuUpdateRequest->validated());
    }
}
