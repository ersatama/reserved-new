<?php


namespace App\Domain\Contracts;


class ReservationContract extends MainContract
{
    const TABLE =   'reservations';

    const FILLABLE  =   [
        self::USER_ID,
        self::ORGANIZATION_ID,
        self::POSITION_ID,
        self::START_TIME,
        self::DATE,
        self::NAME,
        self::PHONE
    ];
}
