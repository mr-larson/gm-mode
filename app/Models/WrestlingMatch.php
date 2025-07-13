<?php

namespace App\Models;

use App\Enums\MatchType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WrestlingMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_id',
        'type',
        'description',
    ];

    protected $casts = [
        'type' => MatchType::class,
    ];

    // 🔗 Relations

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'match_worker')
            ->withPivot(['team', 'is_winner'])
            ->withTimestamps();
    }

    // 🧠 Helpers
    public function winners()
    {
        return $this->workers()->wherePivot('is_winner', true);
    }

    public function losers()
    {
        return $this->workers()->wherePivot('is_winner', false);
    }
}
