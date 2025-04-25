<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'size',
        'duration',
        'status',
        'uploaded_at',
        'processed_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'processed_at' => 'datetime',
    ];
} 