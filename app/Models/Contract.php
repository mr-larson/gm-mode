<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id', 'brand_id', 'game_session_id', 'start_date', 'end_date', 'salary', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'salary' => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }
}

