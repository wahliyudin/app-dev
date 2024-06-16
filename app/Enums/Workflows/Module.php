<?php

namespace App\Enums\Workflows;

enum Module: string
{
    case REQUEST = 'REQUEST';

    public function label()
    {
        return match ($this) {
            self::REQUEST => 'Request',
        };
    }

    public static function byValue(string $val): Module|null
    {
        return match ($val) {
            Module::REQUEST->value => Module::REQUEST,
            default => null
        };
    }
}
