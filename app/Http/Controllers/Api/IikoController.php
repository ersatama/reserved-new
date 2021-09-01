<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Iiko\IikoService;
use App\Services\Iiko\IikoTables\IikoTablesService;
use App\Services\Iiko\IikoTableList\IikoTableListService;

class IikoController extends Controller
{
    protected $iikoService;
    protected $iikoTablesService;
    protected $iikoTableListService;
    public function __construct(IikoService $iikoService, IikoTablesService $iikoTablesService, IikoTableListService $iikoTableListService)
    {
        $this->iikoService  =   $iikoService;
        $this->iikoTablesService    =   $iikoTablesService;
        $this->iikoTableListService =   $iikoTableListService;
    }



}
