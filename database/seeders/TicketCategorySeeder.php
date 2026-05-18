<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        TicketCategory::insert([
            [
                'name' => 'Normal',
                'slug' => 'normal',
                'base_price' => 100000,
                'quota' => 200,
                'sold' => 0,
                'icon' => 'ticket',
                'benefits' => json_encode(['Akses masuk pertunjukan', 'Tempat duduk reguler', 'E-ticket PDF via Email + Notif WA']),
                'is_active' => true,
            ],
            [
                'name' => 'VIP',
                'slug' => 'vip',
                'base_price' => 200000,
                'quota' => 50,
                'sold' => 0,
                'icon' => 'crown',
                'benefits' => json_encode(['Akses masuk pertunjukan', 'Tempat duduk baris depan', 'Merchandise eksklusif', 'Sesi foto bersama pemain', 'E-ticket PDF via Email + Notif WA']),
                'is_active' => true,
            ],
        ]);
    }
}
