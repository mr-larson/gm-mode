<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameSession extends Model
{
    use HasFactory;

    protected $table = 'game_sessions';
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

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'game_session_brand')
            ->using(GameSessionBrand::class)
            ->withPivot(['is_human','draft_order', 'is_draft_complete'])
            ->withTimestamps();
    }

    public function pivotBrands()
    {
        return $this->hasMany(GameSessionBrand::class)
            ->orderBy('draft_order')
            ->with('brand.contracts.worker');

    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function isDraftComplete(): bool
    {
        return !$this->pivotBrands()->where('is_draft_complete', false)->exists();
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}

