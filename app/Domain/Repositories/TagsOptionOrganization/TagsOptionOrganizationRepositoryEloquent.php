<?php

namespace App\Domain\Repositories\TagsOptionOrganization;

use App\Domain\Contracts\MainContract;
use App\Models\TagsOptionOrganization;
use App\Domain\Contracts\TagsOptionOrganizationContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TagsOptionOrganizationRepositoryEloquent implements TagsOptionOrganizationRepositoryInterface
{
    public function update($data)
    {
        if ($tagsOptionOrganization =   TagsOptionOrganization::where([
            MainContract::ORGANIZATION_ID   =>  $data[MainContract::ORGANIZATION_ID],
            MainContract::TAGS_OPTION_ID    =>  $data[MainContract::TAGS_OPTION_ID],
        ])->first()) {
            $tagsOptionOrganization->{MainContract::STATUS} =   $data[MainContract::STATUS];
            $tagsOptionOrganization->save();
        } else {
            $this->create($data);
        }
    }

    public function create($data)
    {
        return TagsOptionOrganization::create($data);
    }

    public function getByOrganizationId($organizationId): Collection
    {
        return DB::table(TagsOptionOrganizationContract::TABLE)
            ->where(MainContract::ORGANIZATION_ID,$organizationId)
            ->get();
    }
}
