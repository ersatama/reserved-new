<?php


namespace App\Domain\Contracts;


class PaymentContract extends MainContract
{
    const TABLE =  'payments';

    const FILLABLE  =   [
        self::BOOKING_ID,
        self::PRICE,
        self::PG_PAYMENT_ID,
        self::PG_REDIRECT_URL,
        self::PG_SIG,
        self::STATUS
    ];
}
