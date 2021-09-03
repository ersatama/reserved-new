<?php

namespace App\Domain\Repositories\Tags;

use App\Models\Tags;

class TagsRepositoryEloquent implements TagsRepositoryInterface
{
    public function list()
    {
        return Tags::with('tagsOption')->get();
    }
}
