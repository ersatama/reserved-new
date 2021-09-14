<?php


namespace App\Domain\Contracts;


class OrganizationContract extends MainContract
{
    const TABLE =   'organizations';

    const FILLABLE  =   [
        self::USER_ID,
        self::CITY_ID,
        self::CATEGORY_ID,
        self::IIKO_ORGANIZATION_ID,
        self::IIKO_ID,
        self::API_KEY,
        self::API_ID,
        self::API_SECRET,
        self::TITLE,
        self::RATING,
        self::WALLPAPER,
        self::IMAGE,
        self::DESCRIPTION,
        self::DESCRIPTION_KZ,
        self::DESCRIPTION_EN,
        self::_2GIS,
        self::ADDRESS,
        self::ADDRESS_KZ,
        self::ADDRESS_EN,
        self::PRICE,
        self::TIMEZONE,
        self::EMAIL,
        self::PHONE,
        self::WEBSITE,
        self::INSTAGRAM,
        self::FACEBOOK,
        self::YOUTUBE,
        self::VK,
        self::TABLES,

        self::START_MONDAY,
        self::END_MONDAY,
        self::WORK_MONDAY,

        self::START_TUESDAY,
        self::END_TUESDAY,
        self::WORK_TUESDAY,

        self::START_WEDNESDAY,
        self::END_WEDNESDAY,
        self::WORK_WEDNESDAY,

        self::START_THURSDAY,
        self::END_THURSDAY,
        self::WORK_THURSDAY,

        self::START_FRIDAY,
        self::END_FRIDAY,
        self::WORK_FRIDAY,

        self::START_SATURDAY,
        self::END_SATURDAY,
        self::WORK_SATURDAY,

        self::START_SUNDAY,
        self::END_SUNDAY,
        self::WORK_SUNDAY,

        self::STATUS
    ];
}
