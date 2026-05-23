<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case USER = 'user';
    case PROFESSIONAL = 'professional';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::AGENT => 'Real Estate Agent',
            self::USER => 'Regular User',
            self::PROFESSIONAL => 'Real Estate Professional',
        };
    }
}
