<?php

namespace App\Domain\Contracts;

class MenuContract extends MainContract
{
    const TABLE     =   'menus';

    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::IMAGE,
        self::STATUS,
    ];
}
