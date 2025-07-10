<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerAlignment: string
{
    use WithDisplayName;

    case face = 'Face';
    case heel = 'Heel';
    case tweener = 'Tweener';
}
