<?php

namespace App\Domain\Contracts;

class TagsOptionContract extends MainContract
{
    const TABLE =   'tags_options';
    const FILLABLE  =   [
        self::TAGS_ID,
        self::TITLE,
        self::TITLE_EN,
        self::TITLE_KZ,
        self::STATUS
    ];
}
