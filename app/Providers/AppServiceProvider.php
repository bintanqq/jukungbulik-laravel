<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            // Safety net: alert if debug mode is accidentally enabled in production
            if (config('app.debug')) {
                Log::critical('⚠️ APP_DEBUG is TRUE in production! This exposes sensitive error details to users. Set APP_DEBUG=false in .env immediately.');
            }
        }

        RateLimiter::for('ticket_purchase', function (Request $request) {
            $clientIP = $request->header('CF-Connecting-IP') ?? $request->ip();
            $email = $request->input('email');
            $whatsapp = $request->input('whatsapp');

            return [
                Limit::perMinute(5)->by($clientIP),
                Limit::perMinute(3)->by($email ? strtolower(trim($email)) : $clientIP),
                Limit::perMinute(3)->by($whatsapp ? trim($whatsapp) : $clientIP),
            ];
        });
    }
}

