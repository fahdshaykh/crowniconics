<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SUCCEEDED = 'succeeded';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case CANCELED = 'canceled';

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
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SUCCEEDED => 'Succeeded',
            self::FAILED => 'Failed',
            self::REFUNDED => 'Refunded',
            self::CANCELED => 'Canceled',
        };
    }

    /**
     * Get status color for UI
     */
    public function color(): string
    {
        return match($this) {
            self::SUCCEEDED => 'success',
            self::PENDING, self::PROCESSING => 'warning',
            self::FAILED, self::CANCELED => 'danger',
            self::REFUNDED => 'info',
        };
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this === self::SUCCEEDED;
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this === self::PENDING || $this === self::PROCESSING;
    }

    /**
     * Check if payment failed
     */
    public function isFailed(): bool
    {
        return $this === self::FAILED || $this === self::CANCELED;
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded(): bool
    {
        return $this === self::REFUNDED;
    }
}