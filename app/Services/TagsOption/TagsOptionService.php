<?php

namespace App\Services\TagsOption;

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
}
