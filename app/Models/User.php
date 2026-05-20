<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    /**
     * Restrict admin panel access to configured admin email(s) only.
     * Without this, ANY user in the users table could access the full admin panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        $allowedEmail = config('services.filament.admin_email', env('FILAMENT_ADMIN_EMAIL'));

        if (!$allowedEmail) {
            return false;
        }

        return strtolower($this->email) === strtolower($allowedEmail);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

