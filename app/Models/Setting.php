<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description'
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value, string $description = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );
    }

    public static function getJamBuka(): string
    {
        return static::get('jam_buka', '06:00');
    }

    public static function getJamTutup(): string
    {
        return static::get('jam_tutup', '23:00');
    }

    public static function setJamOperasional(string $jamBuka, string $jamTutup): void
    {
        static::set('jam_buka', $jamBuka, 'Jam buka GOR Ratu Jaya');
        static::set('jam_tutup', $jamTutup, 'Jam tutup GOR Ratu Jaya');
    }
}
