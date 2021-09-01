<?php


namespace App\Domain\Contracts;


class OrganizationTablesContract extends MainContract
{
    const TABLE =   'organization_tables';

    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::NAME,
        self::STATUS,
    ];
}
