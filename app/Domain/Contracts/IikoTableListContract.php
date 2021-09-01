<?php


namespace App\Domain\Contracts;


class IikoTableListContract extends MainContract
{
    const TABLE =   'iiko_table_lists';

    const FILLABLE  =   [
        self::IIKO_MAIN_ID,
        self::IIKO_TABLE_ID,
        self::ORGANIZATION_TABLE_LIST_ID,
        self::KEY,
        self::TITLE,
        self::LIMIT,
        self::STATUS
    ];
}
