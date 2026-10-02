<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Import ini

class Activity extends Model
{
    use HasFactory, SoftDeletes; // <-- Pasang SoftDeletes di sini

    protected $guarded = [];

    protected $casts = [
        'activity_date' => 'date',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}