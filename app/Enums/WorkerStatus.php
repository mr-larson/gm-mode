<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerStatus: string
{
    use WithDisplayName;

    case Active = 'active';
    case Injured = 'injured';
    case Suspended = 'suspended';
    case Retired = 'retired';
}

