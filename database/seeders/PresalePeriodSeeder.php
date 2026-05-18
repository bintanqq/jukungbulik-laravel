<?php

namespace Database\Seeders;

use App\Models\PresalePeriod;
use Illuminate\Database\Seeder;

class PresalePeriodSeeder extends Seeder
{
    public function run(): void
    {
        PresalePeriod::insert([
            [
                'name' => 'Presale 1',
                'slug' => 'presale-1',
                'discount' => 25,
                'badge' => 'HEMAT 25%',
                'starts_at' => '2026-07-01 00:00:00',
                'ends_at' => '2026-07-15 23:59:59',
                'is_active' => true,
            ],
            [
                'name' => 'Presale 2',
                'slug' => 'presale-2',
                'discount' => 15,
                'badge' => 'HEMAT 15%',
                'starts_at' => '2026-07-16 00:00:00',
                'ends_at' => '2026-07-31 23:59:59',
                'is_active' => true,
            ],
            [
                'name' => 'Normal',
                'slug' => 'normal',
                'discount' => 0,
                'badge' => null,
                'starts_at' => '2026-08-01 00:00:00',
                'ends_at' => '2026-10-01 18:00:00',
                'is_active' => true,
            ],
        ]);
    }
}
