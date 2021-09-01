<?php


namespace App\Domain\Contracts;


class PositionContract extends MainContract
{
    const TABLE =   'positions';

    const FILLABLE  =   [
        self::NAME,
        self::ORGANIZATION_ID,
        self::IS_AVAILABLE
    ];
}
