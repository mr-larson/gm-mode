<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerAlignment: string
{
    use WithDisplayName;

    case face = 'face';
    case heel = 'heel';
    case tweener = 'tweener';
}
