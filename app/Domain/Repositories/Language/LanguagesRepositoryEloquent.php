<?php


namespace App\Domain\Repositories\Language;

use App\Models\Languages;

class LanguagesRepositoryEloquent implements LanguagesRepositoryInterface
{
    public function list()
    {
        return Languages::get();
    }
}
