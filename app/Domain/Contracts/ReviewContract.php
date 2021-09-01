<?php


namespace App\Domain\Contracts;


class ReviewContract extends MainContract
{
    const TABLE =   'reviews';

    const FILLABLE  =   [
        self::BOOKING_ID,
        self::ORGANIZATION_ID,
        self::USER_ID,
        self::RATING,
        self::COMMENT,
        self::STATUS,
    ];
}
