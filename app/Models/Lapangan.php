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

    public function isFullyBookedOnDate($date)
{
    // Ambil semua slot waktu dari jam 06:00 sampai 23:00
    $totalSlot = 17; // Misalnya 06:00 - 23:00 = 17 slot per hari
    $bookedCount = $this->bookings()
        ->whereDate('tanggal', $date)
        ->count();

    return $bookedCount >= $totalSlot;
}
    // Relasi ke bookings
    public function bookings()
{
    return $this->hasMany(Booking::class);
}

}
