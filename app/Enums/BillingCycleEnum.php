<?php

namespace App\Enums;

enum BillingCycleEnum: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case QUARTERLY = 'quarterly';
    case ONE_TIME = 'one_time';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
            self::QUARTERLY => 'Quarterly',
            self::ONE_TIME => 'One Time',
        };
    }

    public function days(): int
    {
        return match ($this) {
            self::MONTHLY => 30,
            self::YEARLY => 365,
            self::QUARTERLY => 90,
            self::ONE_TIME => 0,
        };
    }

    public function isRecurring(): bool
    {
        return in_array($this, [self::MONTHLY, self::YEARLY, self::QUARTERLY]);
    }
}