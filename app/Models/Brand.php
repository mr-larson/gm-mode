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

    public function contracts()
    {
        return $this->hasMany(Contract::class);
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
}

