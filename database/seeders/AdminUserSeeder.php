<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('FILAMENT_ADMIN_EMAIL', 'admin@jukungbulik.id');
        $password = env('FILAMENT_ADMIN_PASSWORD', 'password');

        // Prevent deploying with weak admin password in production
        if (app()->environment('production') && strlen($password) < 12) {
            throw new \RuntimeException(
                'FILAMENT_ADMIN_PASSWORD terlalu lemah untuk production! Minimal 12 karakter. '
                . 'Set password yang kuat di file .env sebelum menjalankan seeder.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Jukung Bulik',
                'password' => Hash::make($password),
            ]
        );
    }
}
