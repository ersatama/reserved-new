<?php


namespace App\Domain\Contracts;


class ShopCategoryContract extends MainContract
{
    const TABLE =   'shop_categories';

    const FILLABLE  =   [
        self::NAME,
        self::IMAGE,
    ];
}
