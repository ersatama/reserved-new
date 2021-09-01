<?php


namespace App\Domain\Repositories\Privacy;

use App\Models\Privacy;
use App\Domain\Contracts\PrivacyContract;

class PrivacyRepositoryEloquent implements PrivacyRepositoryInterface
{
    public function get():object
    {
        return Privacy::get();
    }
}
