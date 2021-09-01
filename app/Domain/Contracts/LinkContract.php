<?php


namespace App\Domain\Contracts;


class LinkContract extends MainContract
{
    const TABLE =   'links';

    const FILLABLE  =   [
        self::KEY,
        self::URL,
        self::EXPIRATION,
        self::STATUS
    ];
}
