<?php


namespace App\Domain\Contracts;


class CategoryContract extends MainContract
{
    const TABLE =   'categories';

    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN,
        self::DESCRIPTION,
        self::DESCRIPTION_KZ,
        self::DESCRIPTION_EN,
        self::IMAGE,
        self::WALLPAPER,
        self::SLUG,
    ];
}
