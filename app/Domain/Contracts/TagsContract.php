<?php

namespace App\Domain\Contracts;

class TagsContract extends MainContract
{
    const TABLE =   'tags';

    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN
    ];
}
