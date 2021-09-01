<?php


namespace App\Services\Contracts;

use App\Domain\Repositories\Contract\ContractRepositoryInterface;
use App\Services\BaseService;

class ContractService extends BaseService
{
    protected $contractRepository;
    public function __construct(ContractRepositoryInterface $contractRepository)
    {
        $this->contractRepository   =   $contractRepository;
    }

    public function get():object
    {
        return $this->contractRepository->get();
    }
}
