<?php

namespace App\Enums;

use App\Traits\WithDisplayName;


enum MatchType: string
{
    use WithDisplayName;

    case OneVsOne = '1v1';
    case TagTeam = 'tag';
    case TripleThreat = 'triple_threat';
    case Fatal4Way = 'fatal_4_way';
    case Handicap = 'handicap';
    case BattleRoyal = 'battle_royal';
    case HellInACell = 'hell_in_a_cell';
    case Submission = 'submission';

    public function label(): string
    {
        return match ($this) {
            self::OneVsOne => '1 vs 1',
            self::TagTeam => 'Tag Team',
            self::TripleThreat => 'Triple Threat',
            self::Fatal4Way => 'Fatal 4-Way',
            self::Handicap => 'Handicap',
            self::BattleRoyal => 'Battle Royal',
            self::HellInACell => 'Hell in a Cell',
            self::Submission => 'Submission Match',
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
