<?php

namespace App\Domain\Contracts;

class TagsOptionOrganizationContract extends MainContract
{
    const TABLE =   'tags_option_organizations';

    const FILLABLE  =   [
        self::TAGS_OPTION_ID,
        self::ORGANIZATION_ID,
        self::STATUS
    ];
}
