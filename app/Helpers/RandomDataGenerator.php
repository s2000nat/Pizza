<?php

namespace App\Helpers;

class RandomDataGenerator
{

    public static function randomPhoneNumberGenerator(): string
    {
        $phoneNumber = '8';

        for ($i = 0; $i < 10; $i++) {
            $phoneNumber .= rand(0, 9);
        }
        return $phoneNumber;
    }
}
