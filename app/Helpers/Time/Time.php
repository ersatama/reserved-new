<?php


namespace App\Helpers\Time;

use App\Domain\Contracts\MainContract;
use DateTime;

class Time
{
    public static function toLocal($dateTime,$timezone):string
    {
        $time   =   new \DateTime($dateTime, new \DateTimeZone($timezone));
        $time->setTimezone(new \DateTimeZone(MainContract::UTC));
        return $time->format('H:i:s');
    }

    public static function convertDate($date, $timezone):string
    {
        $time   =   new \DateTime($date, new \DateTimeZone(MainContract::UTC));
        $time->setTimezone(new \DateTimeZone($timezone));
        return $time->format('Y-m-d');
    }

    public static function currentDateTimezone($timezone):string
    {
        $time   =   new \DateTime('now', new \DateTimeZone($timezone) );
        return $time->format('Y-m-d');
    }

    public static function currentTimestampTimezone($timezone):string
    {
        $time   =   new \DateTime('now', new \DateTimeZone($timezone) );
        $time->modify('-15 minutes');
        return $time->format('Y-m-d H:i:s');
    }

    public function modify($time)
    {
        $date   =   new DateTime;
        $date->modify($time);
        return $date->format('Y-m-d H:i:s');
    }

}
