<?php


namespace App\Domain\Contracts;


class CityContract extends MainContract
{
    const TABLE =   'cities';

    const FILLABLE  =   [
        self::COUNTRY_ID,
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN
    ];
}
