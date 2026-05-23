<?php

namespace App\Enums;

enum PriceTypeEnum: string
{
    case FIXED = 'fixed';
    case NEGOTIABLE = 'negotiable';
    case PER_MONTH = 'per_month';
    case PER_YEAR = 'per_year';
    case PER_SQFT = 'per_sqft';
    case PER_SQM = 'per_sqm';
    case AUCTION = 'auction';
    case CONTACT_FOR_PRICE = 'contact_for_price';
    case FREE = 'free';

    public function label(): string
    {
        return match ($this) {
            self::FIXED => 'Fixed Price',
            self::NEGOTIABLE => 'Negotiable',
            self::PER_MONTH => 'Per Month',
            self::PER_YEAR => 'Per Year',
            self::PER_SQFT => 'Per Sq Ft',
            self::PER_SQM => 'Per Sq Meter',
            self::AUCTION => 'Auction',
            self::CONTACT_FOR_PRICE => 'Contact for Price',
            self::FREE => 'Free',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FIXED => 'currency-dollar',
            self::NEGOTIABLE => 'handshake',
            self::PER_MONTH, self::PER_YEAR => 'calendar',
            self::PER_SQFT, self::PER_SQM => 'square',
            self::AUCTION => 'gavel',
            self::CONTACT_FOR_PRICE => 'phone',
            self::FREE => 'gift',
        };
    }

    public function isRecurring(): bool
    {
        return in_array($this, [self::PER_MONTH, self::PER_YEAR]);
    }

    public function isUnitBased(): bool
    {
        return in_array($this, [self::PER_SQFT, self::PER_SQM]);
    }

    public function requiresContact(): bool
    {
        return $this === self::CONTACT_FOR_PRICE || $this === self::NEGOTIABLE;
    }
}