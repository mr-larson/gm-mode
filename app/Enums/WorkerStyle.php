<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerStyle: string
{
    use WithDisplayName;

    case brawler = 'Brawler';
    case technician = 'Technician';
    case highFlyer = 'High flyer';
    case powerhouse = 'Powerhouse';
    case specialist = 'Specialist'; // Joker : compatible avec tous
}

