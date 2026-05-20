<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Jobs\SendWhatsAppNotification;
use App\Jobs\GenerateAndEmailTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Validate callback token — this is the PRIMARY defense against forged webhooks
        $callbackToken = $request->header('x-callback-token');
        if (!$callbackToken || !hash_equals(config('services.xendit.webhook_token'), $callbackToken)) {
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

        // Use transaction + row lock to prevent double-processing from webhook retries
        $result = DB::transaction(function () use ($data) {
            $order = Order::where('ticket_code', $data['external_id'])
                ->lockForUpdate()
                ->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Idempotency: already processed — safe to return 200
            if ($order->payment_status === 'confirmed') {
                return response()->json(['message' => 'Already processed'], 200);
            }

            // CRITICAL: Verify paid amount matches order total
            // Prevents attacks where someone forges a webhook with amount=1
            $paidAmount = (int) ($data['amount'] ?? 0);
            if ($paidAmount !== (int) $order->total_price) {
                Log::critical('Xendit webhook: AMOUNT MISMATCH — possible fraud attempt', [
                    'order_id' => $order->id,
                    'ticket_code' => $order->ticket_code,
                    'expected' => $order->total_price,
                    'received' => $paidAmount,
                    'data' => $data,
                ]);
                return response()->json(['message' => 'Amount mismatch'], 400);
            }

            // Update payment status (using direct assignment, not mass-assignment)
            $order->payment_status = 'confirmed';
            $order->xendit_payment_method = $data['payment_method'] ?? null;
            $order->payment_confirmed_at = now();
            $order->save();

            // Atomically increment sold count within the transaction
            $order->ticketCategory->increment('sold', $order->quantity);

            // Dispatch notifications
            SendWhatsAppNotification::dispatch($order)->onQueue('notifications');
            GenerateAndEmailTicket::dispatch($order)->onQueue('emails');

            return response()->json(['message' => 'OK'], 200);
        });

        return $result;
    }
}

