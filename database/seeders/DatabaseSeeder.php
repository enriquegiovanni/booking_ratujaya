<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $settings = [
            [
                'key' => 'jam_buka',
                'value' => '06:00',
                'description' => 'Jam buka GOR Ratu Jaya'
            ],
            [
                'key' => 'jam_tutup',
                'value' => '23:00',
                'description' => 'Jam tutup GOR Ratu Jaya'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
