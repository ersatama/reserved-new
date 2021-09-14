<?php

namespace App\Domain\Contracts;

class NewsSubscribeContract extends MainContract
{
    const TABLE =   'news_subscribes';

    const FILLABLE  =   [
        self::USER_ID,
        self::ORGANIZATION_ID,
        self::STATUS
    ];
}
