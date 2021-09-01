<?php


namespace App\Domain\Contracts;


class CardContract extends MainContract
{
    const TABLE =   'cards';

    const FILLABLE  =   [
        self::USER_ID,
        self::CARD_ID,
        self::HASH,
        self::MONTH,
        self::YEAR,
        self::BANK,
        self::COUNTRY,
        self::CARD_3D,
        self::STATUS
    ];
}
