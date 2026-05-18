<?php

namespace Database\Seeders;

use App\Models\EventSetting;
use Illuminate\Database\Seeder;

class EventSettingSeeder extends Seeder
{
    public function run(): void
    {
        EventSetting::insert([
            ['key' => 'event_name', 'value' => 'Jukung Bulik'],
            ['key' => 'event_date', 'value' => '01 Oktober 2026'],
            ['key' => 'event_time', 'value' => '19.00 WITA'],
            ['key' => 'event_venue', 'value' => 'Gedung Balairung Banjarmasin'],
            ['key' => 'event_city', 'value' => 'Banjarmasin'],
            ['key' => 'contact_whatsapp', 'value' => '081234567890'],
            ['key' => 'contact_instagram', 'value' => '@jukungbulik'],
            ['key' => 'hero_overlay_opacity', 'value' => '0.8'],
        ]);
    }
}
