<?php

namespace App\Services\Tags;

use App\Domain\Repositories\Tags\TagsRepositoryInterface;

class TagsService
{
    protected $tagsRepository;
    public function __construct(TagsRepositoryInterface $tagsRepository)
    {
        $this->tagsRepository   =   $tagsRepository;
    }

    public function list()
    {
        return $this->tagsRepository->list();
    }
}
