<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SUCCEEDED = 'succeeded';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SUCCEEDED => 'Succeeded',
            self::FAILED => 'Failed',
            self::REFUNDED => 'Refunded',
            self::CANCELED => 'Canceled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING, self::PROCESSING => 'warning',
            self::SUCCEEDED => 'success',
            self::FAILED, self::CANCELED => 'danger',
            self::REFUNDED => 'info',
        };
    }

    public function isSuccessful(): bool
    {
        return $this === self::SUCCEEDED;
    }

    public function isPending(): bool
    {
        return in_array($this, [self::PENDING, self::PROCESSING]);
    }

    public function isFailed(): bool
    {
        return in_array($this, [self::FAILED, self::CANCELED]);
    }
}