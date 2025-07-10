<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerStatus: string
{
    use WithDisplayName;

    case active = 'Active';
    case injured = 'Injured';
    case suspended = 'Suspended';
    case retired = 'Retired';
}

