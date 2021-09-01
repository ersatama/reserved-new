<?php


namespace App\Domain\Contracts;


class IikoTablesContract extends MainContract
{
    const TABLE =   'iiko_tables';

    const FILLABLE =   [
        self::IIKO_MAIN_ID,
        self::KEY,
        self::NAME,
        self::STATUS
    ];
}
