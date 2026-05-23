<?php

namespace App\Enums;

enum FeatureEnum: string
{
    case SWIMMING_POOL = 'swimming_pool';
    case GYM = 'gym';
    case BALCONY = 'balcony';
    case GARDEN = 'garden';
    case SECURITY = 'security';
    case PLAY_AREA = 'play_area';

    public function label(): string
    {
        return match ($this) {
            self::SWIMMING_POOL => 'Swimming Pool',
            self::GYM => 'Gym',
            self::BALCONY => 'Balcony',
            self::GARDEN => 'Garden',
            self::SECURITY => 'Security',
            self::PLAY_AREA => 'Play Area',
        };
    }
}
