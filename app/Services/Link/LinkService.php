<?php


namespace App\Services\Link;

use App\Services\BaseService;
use App\Domain\Repositories\Link\LinkRepositoryInterface;

class LinkService extends BaseService
{
    protected $linkRepository;
    public function __construct(LinkRepositoryInterface $linkRepository)
    {
        $this->linkRepository   =   $linkRepository;
    }

    public function getById($id) {
        return $this->linkRepository->getById($id);
    }
}
