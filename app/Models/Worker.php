<?php

namespace App\Models;

use App\Enums\WorkerAlignment;
use App\Enums\WorkerCategory;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'workers';

    protected $fillable = [
        'firstname',
        'lastname',
        'nickname',
        'gender',
        'age',
        'style',
        'status',
        'category',
        'alignment',
        'height',
        'weight',
        'image',
        'overall',
        'popularity',
        'endurance',
        'promo_skill',
        'wins',
        'draws',
        'losses',
        'note',
        'brand_id',
        'user_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'gender' => WorkerGender::class,
        'status' => WorkerStatus::class,
        'category' => WorkerCategory::class,
        'style' => WorkerStyle::class,
        'alignment' => WorkerAlignment::class,

        'age' => 'integer',
        'height' => 'integer',
        'weight' => 'integer',
        'overall' => 'integer',
        'popularity' => 'integer',
        'endurance' => 'integer',
        'promo_skill' => 'integer',
        'wins' => 'integer',
        'draws' => 'integer',
        'losses' => 'integer',
    ];

    // Relations

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors

    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->lastname}");
    }

    public function getPerformanceScoreAttribute(): int
    {
        return $this->wins * 3 + $this->draws;
    }
}
