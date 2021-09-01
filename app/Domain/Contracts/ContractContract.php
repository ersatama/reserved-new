<?php


namespace App\Domain\Contracts;


class ContractContract extends MainContract
{
    const TABLE =   'contracts';

    const FILLABLE  =   [
        self::JSON
    ];
}
