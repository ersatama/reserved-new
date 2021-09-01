<?php


namespace App\Services\Language;

use App\Domain\Repositories\Language\LanguagesRepositoryInterface;

class LanguagesService
{
    protected $languagesRepository;
    public function __construct(LanguagesRepositoryInterface $languagesRepository)
    {
        $this->languagesRepository  =   $languagesRepository;
    }

    public function list()
    {
        return $this->languagesRepository->list();
    }

}
