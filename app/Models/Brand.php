<?php

namespace App\Models;

use App\Enums\BrandColor;
use App\Enums\BrandStyle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'brands';
    protected $appends = ['ranked_workers', 'founded_formatted'];

    protected $fillable = [
        'name', 'owner', 'booker', 'based_in', 'country',
        'money', 'style', 'color', 'popularity',
        'founded', 'description', 'image',
        'user_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $casts = [
        'founded' => 'date',
        'style' => BrandStyle::class,
        'color' => BrandColor::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    public function sessions()
    {
        return $this->belongsToMany(GameSession::class, 'game_session_brand')
            ->withPivot(['is_human','draft_order', 'is_draft_complete'])
            ->withTimestamps();
    }

    public function pivotBrand(GameSession $session)
    {
        return $this->hasOne(GameSessionBrand::class)
            ->where('game_session_id', $session->id);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class)->where('is_active', true);
    }

    public function allContracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function sessionContracts($sessionId)
    {
        return $this->allContracts()
            ->where('game_session_id', $sessionId)
            ->where('is_active', true);
    }

    public function workers()
    {
        return $this->hasManyThrough(
            Worker::class,
            Contract::class,
            'brand_id',
            'id',
            'id',
            'worker_id'
        )->where('contracts.is_active', true);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function remainingBudget(): int
    {
        return $this->money - $this->contracts->sum('salary');
    }

    public function totalSalary(): int
    {
        return $this->contracts->sum('salary');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    public function getRankedWorkersAttribute()
    {
        return $this->workers()
            ->get()
            ->sortByDesc(fn($worker) => $worker->wins * 3 + $worker->draws);
    }

    public function getFoundedFormattedAttribute(): ?string
    {
        return $this->founded?->format('d/m/Y'); // ou 'Y-m-d'
    }

    public function getRemainingBudgetFormattedAttribute(): ?string
    {
        return number_format($this->remainingBudget(), 0, ',', ' ');
    }
}

