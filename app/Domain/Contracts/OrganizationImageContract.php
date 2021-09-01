<?php


namespace App\Domain\Contracts;


class OrganizationImageContract extends MainContract
{
    const TABLE =   'organization_images';

    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::IMAGE,
        self::STATUS,
    ];
}
