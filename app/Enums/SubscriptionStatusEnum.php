<?php

namespace App\Enums;

enum SubscriptionStatusEnum: string
{
    case ACTIVE = 'active';
    case CANCELED = 'canceled';
    case PAST_DUE = 'past_due';
    case UNPAID = 'unpaid';
    case INCOMPLETE = 'incomplete';
    case TRIALING = 'trialing';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::CANCELED => 'Canceled',
            self::PAST_DUE => 'Past Due',
            self::UNPAID => 'Unpaid',
            self::INCOMPLETE => 'Incomplete',
            self::TRIALING => 'Trialing',
            self::EXPIRED => 'Expired',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE, self::TRIALING => 'success',
            self::CANCELED, self::EXPIRED => 'secondary',
            self::PAST_DUE, self::UNPAID => 'danger',
            self::INCOMPLETE => 'warning',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::ACTIVE, self::TRIALING]);
    }

    public function canUseFeatures(): bool
    {
        return $this->isActive();
    }
}