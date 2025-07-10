<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerStyle: string
{
    use WithDisplayName;

    case Brawler = 'brawler';
    case Technician = 'technician';
    case HighFlyer = 'high flyer';
    case Powerhouse = 'powerhouse';
    case Specialist = 'specialist'; // Joker : compatible avec tous
}

