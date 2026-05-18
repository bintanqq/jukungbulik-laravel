<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Jukung Bulik',
            'email' => env('FILAMENT_ADMIN_EMAIL', 'admin@jukungbulik.id'),
            'password' => Hash::make(env('FILAMENT_ADMIN_PASSWORD', 'password')),
        ]);
    }
}
