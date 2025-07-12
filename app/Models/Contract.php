<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['worker_id', 'brand_id', 'start_date', 'end_date', 'salary', 'is_active'];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}

