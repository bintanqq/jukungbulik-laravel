<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Jobs\SendWhatsAppNotification;
use App\Jobs\GenerateAndEmailTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function xendit(Request $request)
    {
        $clientIP = $request->header('CF-Connecting-IP') ?? $request->ip();
        $allowedIPs = config('services.xendit.webhook_ips', []);

        if (app()->environment('local', 'testing')) {
            $allowedIPs[] = '127.0.0.1';
            $allowedIPs[] = '::1';
        }

        if (!app()->environment('local', 'testing') && !in_array($clientIP, $allowedIPs)) {
            Log::warning('Xendit webhook: unauthorized IP address', [
                'ip' => $clientIP,
            ]);
            return response()->json(['message' => 'Unauthorized IP'], 401);
        }

        $callbackToken = $request->header('x-callback-token');
        if (!$callbackToken || $callbackToken !== config('services.xendit.webhook_token')) {
            Log::warning('Xendit webhook: invalid token', [
                'ip' => $clientIP,
                'token' => substr($callbackToken ?? '', 0, 5) . '...',
            ]);
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->all();
        
        try {
            Log::channel('webhook')->info('Xendit webhook received', $data);
        } catch (\Exception $e) {
            Log::info('Xendit webhook received', $data);
        }

        if (($data['status'] ?? '') !== 'PAID') {
            return response()->json(['message' => 'Ignored'], 200);
        }

        $order = Order::where('ticket_code', $data['external_id'])->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->payment_status === 'confirmed') {
            return response()->json(['message' => 'Already processed'], 200);
        }

        $order->update([
            'payment_status' => 'confirmed',
            'xendit_payment_method' => $data['payment_method'] ?? null,
            'payment_confirmed_at' => now(),
        ]);

        $order->ticketCategory->increment('sold', $order->quantity);

        SendWhatsAppNotification::dispatch($order)->onQueue('notifications');
        GenerateAndEmailTicket::dispatch($order)->onQueue('emails');

        return response()->json(['message' => 'OK'], 200);
    }
}
