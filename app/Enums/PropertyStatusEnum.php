<?php

namespace App\Enums;

enum PropertyStatusEnum: string
{
    case ACTIVE    = 'active';
    case INACTIVE  = 'inactive';
    case APPROVED  = 'approved';
    case REJECTED  = 'rejected';
    case AVAILABLE = 'available';
    case SOLD      = 'sold';
    case RENTED    = 'rented';
    case DRAFT     = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Active',
            self::INACTIVE  => 'Inactive',
            self::APPROVED  => 'Approved',
            self::REJECTED  => 'Rejected',
            self::AVAILABLE => 'Available',
            self::SOLD      => 'Sold',
            self::RENTED    => 'Rented',
            self::DRAFT     => 'Draft',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE    => 'success',
            self::INACTIVE  => 'danger',
            self::APPROVED  => 'info',
            self::REJECTED  => 'dark',
            self::AVAILABLE => 'success',
            self::SOLD      => 'danger',
            self::RENTED    => 'warning',
            self::DRAFT     => 'secondary',
        };
    }
}
