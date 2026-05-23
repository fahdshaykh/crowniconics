<?php

namespace App\Enums;

enum BooleanEnum: int
{
    case TRUE = 1;
    case FALSE = 0;

    public function label(): string
    {
        return match ($this) {
            self::TRUE => 'active',
            self::FALSE => 'inactive',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TRUE => 'success',
            self::FALSE => 'danger',
        };
    }
}
