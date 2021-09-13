<?php

namespace App\Domain\Contracts;

class NewsContract extends MainContract
{
    const TABLE =   'news';
    const FILLABLE  =   [
        self::ORGANIZATION_ID,
        self::TITLE,
        self::DESCRIPTION,
        self::STATUS
    ];
}
