<?php

namespace App\Traits;

trait EnumHelper
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function random(): self
    {
        return fake()->randomElement(self::cases());
    }
}
