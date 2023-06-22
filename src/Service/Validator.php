<?php

declare(strict_types=1);

namespace App\Service;

class Validator
{
    public static function string($value, $min = 1, $max = INF): bool
    {
        if (is_null($value)) {
            return false;
        }

        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}