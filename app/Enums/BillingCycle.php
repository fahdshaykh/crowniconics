<?php

namespace App\Enums;

enum BillingCycle: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    /**
     * Get all cycle values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get cycle labels for display
     */
    public function label(): string
    {
        return match($this) {
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }

    /**
     * Get cycle color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::MONTHLY => 'primary',
            self::YEARLY => 'success',
        };
    }

    /**
     * Get days in billing cycle
     */
    public function days(): int
    {
        return match($this) {
            self::MONTHLY => 30,
            self::YEARLY => 365,
        };
    }

    /**
     * Get months in billing cycle
     */
    public function months(): int
    {
        return match($this) {
            self::MONTHLY => 1,
            self::YEARLY => 12,
        };
    }
}