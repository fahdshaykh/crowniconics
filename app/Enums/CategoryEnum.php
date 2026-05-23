<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case SELL = 'sell';
    case RENT = 'rent';
    case PROFESSIONAL = 'professional';

    public function label(): string
    {
        return match ($this) {
            self::SELL => 'Sell',
            self::RENT => 'Rent',
            self::PROFESSIONAL => 'Professional',
        };
    }
}
