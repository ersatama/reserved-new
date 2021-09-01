<?php


namespace App\Domain\Repositories\Link;

use App\Models\Link;
use App\Domain\Contracts\LinkContract;

class LinkRepositoryEloquent implements LinkRepositoryInterface {
    public function create($url) {
        return Link::create([
            LinkContract::KEY           =>  md5($url),
            LinkContract::URL           =>  $url,
            LinkContract::EXPIRATION    =>  date("Y-m-d H:i:s", strtotime("+1 hours"))
        ]);
    }

    public function getById($id) {
        $link   =   Link::where([
            [LinkContract::ID,$id],
            [LinkContract::STATUS,LinkContract::ENABLED]
        ])->first();
        if ($link) {
            $link->status   =   LinkContract::DISABLED;
            $link->save();
        }
        return $link;
    }
}
