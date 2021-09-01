<?php


namespace App\Domain\Contracts;


class PrivacyContract extends MainContract
{
    const TABLE =  'privacies';

    const FILLABLE  =   [
        self::JSON
    ];
}
