<?php

namespace App\Domain\Repositories\NewsSubscribe;

use App\Domain\Contracts\NewsSubscribeContract;
use App\Domain\Contracts\MainContract;
use App\Models\NewsSubscribe;
use Illuminate\Support\Facades\DB;

class NewsSubscribeRepositoryEloquent implements NewsSubscribeRepositoryInterface
{
    public function create($data)
    {
        if ($newsSubscribe  =   NewsSubscribe::where([
            [MainContract::ORGANIZATION_ID,$data[MainContract::ORGANIZATION_ID]],
            [MainContract::USER_ID,$data[MainContract::USER_ID]]
        ])->first()) {
            $newsSubscribe->{MainContract::STATUS}  =   MainContract::ON;
            $newsSubscribe->save();
            return $newsSubscribe;
        }
        return NewsSubscribe::create($data);
    }

    public function update($id, $data)
    {
        NewsSubscribe::where(MainContract::ID,$id)->update($data);
    }

    public function getByUserId($userId)
    {
        return DB::table(NewsSubscribeContract::TABLE)
            ->where([
                [MainContract::USER_ID,$userId],
                [MainContract::STATUS,MainContract::ON]
            ])
            ->get();
    }

    public function getByOrganizationIdAndUserId($organizationId, $userId)
    {
        return DB::table(NewsSubscribeContract::TABLE)
            ->where([
                [MainContract::ORGANIZATION_ID,$organizationId],
                [MainContract::USER_ID,$userId]
            ])
            ->first();
    }

}
