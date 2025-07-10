<?php

namespace App\Traits;

trait WithDisplayName
{
    public function displayName(): string
    {
        return $this->value;
    }
}
