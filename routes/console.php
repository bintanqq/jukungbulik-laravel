<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Order;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Order::where('payment_status', 'pending')
        ->where('created_at', '<', now()->subHours(25))
        ->update(['payment_status' => 'expired']);
})->hourly();
