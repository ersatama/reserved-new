<?php

namespace App\Services\Menu;

use App\Services\BaseService;

use App\Domain\Repositories\Menu\MenuRepositoryInterface;
use Illuminate\Support\Collection;

class MenuService
{
    protected $menuRepository;
    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository   =   $menuRepository;
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return $this->menuRepository->getByOrganizationId($organizationId);
    }

    public function create($data)
    {
        return $this->menuRepository->create($data);
    }

    public function update($id, $data):void
    {
        $this->menuRepository->update($id, $data);
    }
}
