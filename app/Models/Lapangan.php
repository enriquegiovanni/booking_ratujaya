<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'title',
        'category',
        'description',
        'price',
        'images',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
        'status' => 'boolean'
    ];

    // Relasi ke bookings
}
