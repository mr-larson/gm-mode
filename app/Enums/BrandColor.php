<?php

namespace App\Enums;

enum BrandColor: string
{
    case red = 'red';
    case orange = 'orange';
    case amber = 'amber';
    case yellow = 'yellow';
    case lime = 'lime';
    case green = 'green';
    case emerald = 'emerald';
    case teal = 'teal';
    case cyan = 'cyan';
    case sky = 'sky';
    case blue = 'blue';
    case indigo = 'indigo';
    case violet = 'violet';
    case purple = 'purple';
    case fuchsia = 'fuchsia';
    case pink = 'pink';
    case rose = 'rose';
    case slate = 'slate';
    case gray = 'gray';
    case zinc = 'zinc';
    case neutral = 'neutral';
    case stone = 'stone';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => ucfirst($case->value)])
            ->toArray();
    }
}
