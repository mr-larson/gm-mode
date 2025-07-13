<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'type', // weekly | ppv
        'scheduled_at',
        'location',
    ];

    protected $casts = [
        'scheduled_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function matches()
    {
        return $this->hasMany(WrestlingMatch::class);
    }

    public function promos()
    {
        return $this->hasMany(Promo::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    public function getIsPpvAttribute(): bool
    {
        return $this->type === 'ppv';
    }

    public function getLabelAttribute(): string
    {
        return sprintf(
            '%s (%s) - %s',
            strtoupper($this->type),
            $this->brand?->name ?? 'Inconnue',
            $this->scheduled_at->format('d/m/Y')
        );
    }

    public function getMatchSlotsCountAttribute(): int
    {
        return $this->isPpv ? 4 : 3;
    }

    public function getPromoSlotsCountAttribute(): int
    {
        return $this->isPpv ? 3 : 2;
    }

    public function getIsPastAttribute(): bool
    {
        return $this->scheduled_at->isPast();
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->scheduled_at->isToday();
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('scheduled_at', '>=', now())->orderBy('scheduled_at');
    }

    public function scopeForBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }
}
