<?php

namespace App\Domain\Repositories\Contract;

use App\Models\Contracts;

class ContractRepositoryEloquent implements ContractRepositoryInterface
{
    public function get():object {
        return Contracts::get();
    }
}
