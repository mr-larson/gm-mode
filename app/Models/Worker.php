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

/**
 * @property mixed $id
 * @property mixed $firstname
 * @property mixed $lastname
 * @property mixed $nickname
 * @property mixed $gender
 * @property mixed $age
 * @property mixed $style
 * @property mixed $status
 * @property mixed $category
 * @property mixed $alignment
 */
class Worker extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workers';

    protected $fillable = [
        'firstname', 'lastname', 'nickname', 'gender', 'age', 'style',
        'status', 'category', 'alignment', 'height', 'weight', 'image',
        'overall', 'popularity', 'endurance', 'promo_skill',
        'wins', 'draws', 'losses', 'note',
        'brand_id', 'user_id', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'gender'    => WorkerGender::class,
        'status'    => WorkerStatus::class,
        'category'  => WorkerCategory::class,
        'style'     => WorkerStyle::class,
        'alignment' => WorkerAlignment::class,
        'age'         => 'integer',
        'height'      => 'integer',
        'weight'      => 'integer',
        'overall'     => 'integer',
        'popularity'  => 'integer',
        'endurance'   => 'integer',
        'promo_skill' => 'integer',
        'wins'        => 'integer',
        'draws'       => 'integer',
        'losses'      => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function currentContract()
    {
        return $this->hasOne(Contract::class)->where('is_active', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
   |--------------------------------------------------------------------------
   | Scope
   |--------------------------------------------------------------------------
   */
    public function scopeDrafted($query)
    {
        return $query->whereHas('contracts');
    }

    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('contracts');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->lastname}");
    }

    public function getPerformanceScoreAttribute(): int
    {
        return ($this->wins * 3) + ($this->draws * 1);
    }

    public function getWinRateAttribute(): float
    {
        $total = $this->wins + $this->draws + $this->losses;
        return $total > 0 ? round(($this->wins / $total) * 100, 1) : 0;
    }

    public function isAvailableForSession(GameSession $session): bool
    {
        return !$this->contracts()->where('game_session_id', $session->id)->exists();
    }

    // Reset des stats pour une brand
    public function initializeStats(): void
    {
        $this->update([
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
        ]);
    }

    public static function resetStatsByBrand(int $brandId): void
    {
        self::where('brand_id', $brandId)->update([
            'wins'   => 0,
            'draws'  => 0,
            'losses' => 0,
        ]);
    }
}
