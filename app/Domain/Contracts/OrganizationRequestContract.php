<?php

namespace App\Domain\Contracts;

class OrganizationRequestContract extends MainContract
{
    const TABLE =   'organization_requests';

    const FILLABLE  =   [
        self::NAME,
        self::PHONE,
        self::ORGANIZATION_NAME,
        self::CATEGORY_ID,
        self::CITY_ID,
        self::STATUS
    ];
}
