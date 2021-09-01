<?php

namespace App\Domain\Contracts;

class WebTrafficContract extends MainContract
{
    const TABLE =   'web_traffic';
    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::WEBSITE,
        self::IP,
        self::STATUS
    ];
}
