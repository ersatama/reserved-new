<?php

namespace App\Domain\Repositories\Menu;

use App\Domain\Contracts\MainContract;
use App\Models\Menu;
use App\Domain\Contracts\MenuContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MenuRepositoryEloquent implements MenuRepositoryInterface
{
    public function getByOrganizationId($organizationId): Collection
    {
        return DB::table(MenuContract::TABLE)->where([
            [MainContract::ORGANIZATION_ID,$organizationId],
            [MainContract::STATUS, MainContract::ON]
        ])->get();
    }

    public function create($data)
    {
        return Menu::create($data);
    }

    public function update($id, $data):void
    {
        DB::table(MenuContract::TABLE)
            ->where(MainContract::ID,$id)
            ->update($data);
    }
}
