<?php


namespace App\Domain\Contracts;


class LanguagesContract extends MainContract
{
    const TABLE =   'languages';

    const FILLABLE  =   [
        self::TITLE,
    ];
}
