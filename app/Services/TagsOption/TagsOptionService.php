<?php

namespace App\Services\TagsOption;

use App\Domain\Contracts\MainContract;
use App\Domain\Repositories\TagsOption\TagsOptionRepositoryInterface;
use Illuminate\Support\Collection;

class TagsOptionService
{
    protected $tagsOptionRepository;
    public function __construct(TagsOptionRepositoryInterface $tagsOptionRepository)
    {
        $this->tagsOptionRepository =   $tagsOptionRepository;
    }

    public function other(): Collection
    {
        return $this->tagsOptionRepository->other();
    }

    public function getByTitle($tag)
    {
        return $this->tagsOptionRepository->getByTitle($tag);
    }

    public function all(): Collection
    {
        return $this->tagsOptionRepository->all();
    }

    public function list(): string
    {
        $tags   =   $this->tagsOptionRepository->list();
        $arr    =   [];
        foreach ($tags as &$tag) {
            $arr[]  =   $tag->{MainContract::TITLE};
        }
        return implode(', ',$arr);
    }
}
