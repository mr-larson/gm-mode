<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'started_at',
        'week',
        'year',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'started_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}

