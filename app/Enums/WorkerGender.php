<?php

namespace App\Enums;

use App\Traits\WithDisplayName;

enum WorkerGender: string
{
    use WithDisplayName;

    case male = 'Male';
    case female = 'Female';
}

