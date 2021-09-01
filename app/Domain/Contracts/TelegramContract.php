<?php

namespace App\Domain\Contracts;

class TelegramContract extends MainContract
{
    const TABLE =   'telegrams';

    const FILLABLE  =   [
        self::USER_ID,
        self::API_TOKEN,
        self::STATUS
    ];
}
