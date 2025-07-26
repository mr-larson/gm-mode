<?php

namespace App\Models;

use App\Enums\PromoType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_id',
        'type',
        'worker_id',
        'content',
    ];

    protected $casts = [
        'type' => PromoType::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function mainSpeaker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'promo_worker')
            ->withPivot(['role', 'order'])
            ->withTimestamps();
    }
}
