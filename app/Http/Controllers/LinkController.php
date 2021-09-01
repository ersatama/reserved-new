<?php

namespace App\Http\Controllers;

use App\Services\Link\LinkService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $linkService;
    public function __construct(LinkService $linkService)
    {
        $this->linkService  =   $linkService;
    }

    public function link($id) {
        $link   =   $this->linkService->getById($id);
        if ($link && (strtotime($link->expiration) > time())) {
            return redirect()->away($link->url);
        }
        return response(['message'  =>  'Ссылка не действительна'],410);
    }
}
