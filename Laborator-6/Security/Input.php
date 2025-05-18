<?php

namespace Security;

use InvalidArgumentException;

final class Input
{
    public static function isInList(string $key, array $allowed, int $default)
    {
        $value = filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT);
        return ($value !== false && in_array($value, $allowed, true)) ? $value : $default;
    }
    public static function intRange(string $key, int $min, int $max, int $default): int
    {
        $value = filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT);
        if ($value === false) {
            return $default;
        }
        if ($value < $min || $value > $max) {
            throw new InvalidArgumentException("Valoare '$key' out-of-range");
        }
        return $value;
    }
}
