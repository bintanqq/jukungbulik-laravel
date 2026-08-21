<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyStreamingSession
{
    /**
     * Verify that the current browser session has a valid streaming token
     * matching the one stored in the database (single-device lock).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('streaming_token');
        $ticketCode = session('streaming_ticket_code');

        if (!$token || !$ticketCode) {
            return redirect()->route('streaming.index')
                ->withErrors(['ticket_code' => 'Sesi streaming tidak ditemukan. Silakan masukkan kode tiket.']);
        }

        $order = Order::where('ticket_code', $ticketCode)->first();

        if (!$order || $order->streaming_session_token !== $token) {
            session()->forget(['streaming_token', 'streaming_ticket_code']);
            return redirect()->route('streaming.index')
                ->withErrors(['ticket_code' => 'Sesi Anda telah berakhir karena tiket ini digunakan di perangkat lain. Silakan masuk kembali.']);
        }

        return $next($request);
    }
}
