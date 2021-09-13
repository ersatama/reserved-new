<?php

namespace App\Domain\Contracts;

class NewsImageContract extends MainContract
{
    const TABLE =   'news_images';
    const FILLABLE  =   [
        self::NEWS_ID,
        self::IMAGE,
        self::STATUS
    ];
}
