<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case Trialing = 'trialing';
    case Active = 'active';
    case PastDue = 'past_due';
    case Canceled = 'canceled';
    case Expired = 'expired';

    public function isActive(): bool
    {
        return match ($this) {
            self::Active, self::Trialing => true,
            default => false,
        };
    }
}
