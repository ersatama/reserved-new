<?php

namespace App\Http\Controllers\Api;

use App\Services\Contracts\ContractService;
use App\Services\Privacy\PrivacyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    protected $contractService;
    protected $privacyService;

    public function __construct(ContractService $contractService, PrivacyService $privacyService)
    {
        $this->contractService  =   $contractService;
        $this->privacyService   =   $privacyService;
    }

    public function contracts():array
    {
        return $this->contractService->get();
    }

    public function privacy():array
    {
        return $this->privacyService->get();
    }

}
