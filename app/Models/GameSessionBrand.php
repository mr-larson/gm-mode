<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GameSessionBrand extends Pivot
{
    protected $table = 'game_session_brand';
    protected $fillable = [
        'game_session_id',
        'brand_id',
        'is_human',
        'draft_order',
        'is_draft_complete',
        'total_picks',
        'budget_spent',
    ];
    protected $casts = [
        'is_human' => 'boolean',
        'is_draft_complete' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function session()
    {
        return $this->belongsTo(GameSession::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class)->with('contracts.worker');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function activeContracts()
    {
        return $this->brand->contracts->where('is_active', true);
    }

    public function draftedWorkers()
    {
        return $this->brand->contracts->where('is_active', true)->pluck('worker');
    }
}
