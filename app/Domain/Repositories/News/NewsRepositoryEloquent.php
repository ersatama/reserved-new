<?php

namespace App\Domain\Repositories\News;

use App\Domain\Contracts\MainContract;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use App\Domain\Contracts\NewsContract;

class NewsRepositoryEloquent implements NewsRepositoryInterface
{

    private $take   =   15;

    public function create($data)
    {
        return News::create($data);
    }

    public function update($id, $data)
    {
        DB::table(NewsContract::TABLE)->where(MainContract::ID,$id)->update($data);
    }

    public function list($page)
    {
        return News::with('organization','newsImages')
            ->where(MainContract::STATUS,MainContract::ON)
            ->orderBy(MainContract::ID,MainContract::DESC)
            ->skip(--$page * $this->take)
            ->take($this->take)
            ->orderBy(MainContract::ID,MainContract::DESC)
            ->get();
    }

    public function getByOrganizationId($organizationId)
    {
        return News::with('organization','newsImages')
            ->where([
                [MainContract::ORGANIZATION_ID,$organizationId],
                [MainContract::STATUS,'!=',MainContract::OFF]
            ])
            ->orderBy(MainContract::ID,MainContract::DESC)
            ->get();
    }

    public function getByOrganizationIdAndStatus($organizationId, $status)
    {
        return News::with('organization','newsImages')
            ->where([
                [MainContract::ORGANIZATION_ID,$organizationId],
                [MainContract::STATUS,$status]
            ])
            ->orderBy(MainContract::ID,MainContract::DESC)
            ->get();
    }

    public function getById($id)
    {
        return News::with('organization','newsImages')
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,'!=',MainContract::OFF]
            ])->first();
    }

    public function getByIdAndStatus($id, $status)
    {
        return News::with('organization','newsImages')->where([
            [MainContract::ID,$id],
            [MainContract::STATUS,$status]
        ])->orderBy(MainContract::ID,MainContract::DESC)->get();
    }

}
