<?php


namespace App\Services\Privacy;

use App\Domain\Repositories\Privacy\PrivacyRepositoryInterface;
use App\Services\BaseService;

class PrivacyService extends BaseService
{
    protected $privacyRepository;
    public function __construct(PrivacyRepositoryInterface $privacyRepository)
    {
        $this->privacyRepository    =   $privacyRepository;
    }

    public function get():object
    {
        return $this->privacyRepository->get();
    }
}
