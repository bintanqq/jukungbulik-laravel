<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BasePage;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends BasePage
{
    public function authenticate(): ?\Filament\Auth\Http\Responses\Contracts\LoginResponse
    {
        try {
            // Limit login attempts to 3 per 60 seconds
            $this->rateLimit(3, 60);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();
            return null;
        }

        return parent::authenticate();
    }
}
