<?php
namespace App\Enums;

use App\Traits\WithDisplayName;

enum PromoType: string
{
    use WithDisplayName;
    case CallOut = 'call_out';
    case SelfPromo = 'self_promo';
    case Interview = 'interview';
    case BackstageBrawl = 'backstage_brawl';
    case Announcement = 'announcement';

    public function label(): string
    {
        return match ($this) {
            self::CallOut => 'Call Out',
            self::SelfPromo => 'Auto-Promo',
            self::Interview => 'Interview',
            self::BackstageBrawl => 'Brawl Backstage',
            self::Announcement => 'Annonce',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['label' => $case->label(), 'value' => $case->value],
            self::cases()
        );
    }
}
