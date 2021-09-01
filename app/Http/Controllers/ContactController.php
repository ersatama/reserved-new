<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ContractService;
use App\Services\Privacy\PrivacyService;
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

    public function contracts()
    {
        $contracts  =   $this->contractService->get();
        return view('contracts.contracts',compact('contracts'));
    }

    public function privacy()
    {
        $privacies  =   $this->privacyService->get();
        return view('privacy.privacy',compact('privacies'));
    }
}
