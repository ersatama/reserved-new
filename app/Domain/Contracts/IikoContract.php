<?php


namespace App\Domain\Contracts;


class IikoContract extends MainContract
{
    const TABLE =   'iikos';

    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::IIKO_ORGANIZATION_ID,
        self::IIKO_ID,
        self::API_KEY,
        self::API_ID,
        self::API_SECRET,
        self::STATUS,
    ];
}
