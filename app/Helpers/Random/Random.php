<?php


namespace App\Helpers\Random;


class Random
{
    const CHARS =   '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public static function generate($length = 10): string
    {
        $size   =   strlen(self::CHARS);
        $random =   '';
        for ($i = 0; $i < $length; $i++) {
            $random .=  self::CHARS[rand(0, $size - 1)];
        }
        return $random;
    }
}
