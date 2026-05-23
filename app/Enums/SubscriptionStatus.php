<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case PAST_DUE = 'past_due';
    case UNPAID = 'unpaid';
    case INCOMPLETE = 'incomplete';
    case TRIALING = 'trialing';
    case EXPIRED = 'expired';

    /**
     * Get all status values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get status labels for display
     */
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::CANCELED => 'Canceled',
            self::PAST_DUE => 'Past Due',
            self::UNPAID => 'Unpaid',
            self::INCOMPLETE => 'Incomplete',
            self::TRIALING => 'Trialing',
            self::EXPIRED => 'Expired',
        };
    }

    /**
     * Get status color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::PENDING => 'warning',
            self::CANCELED => 'secondary',
            self::PAST_DUE => 'danger',
            self::UNPAID => 'danger',
            self::INCOMPLETE => 'warning',
            self::TRIALING => 'info',
            self::EXPIRED => 'danger',
        };
    }

    /**
     * Check if status allows property listing
     */
    public function allowsPropertyListing(): bool
    {
        return match($this) {
            self::ACTIVE, self::TRIALING => true,
            default => false,
        };
    }

    /**
     * Check if status is considered active
     */
    public function isActive(): bool
    {
        return match($this) {
            self::ACTIVE, self::TRIALING => true,
            default => false,
        };
    }

    /**
     * Check if status is expired
     */
    public function isExpired(): bool
    {
        return $this === self::EXPIRED;
    }

    /**
     * Check if status is canceled
     */
    public function isCanceled(): bool
    {
        return $this === self::CANCELED;
    }

    /**
     * Check if status is on trial
     */
    public function isOnTrial(): bool
    {
        return $this === self::TRIALING;
    }
}