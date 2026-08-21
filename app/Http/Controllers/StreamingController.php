<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EventSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StreamingController extends Controller
{
    public function index()
    {
        $enabled = EventSetting::where('key', 'streaming_enabled')->value('value');
        if ($enabled !== 'true') {
            return view('pages.streaming-disabled');
        }

        return view('pages.streaming-login');
    }

    public function authenticate(Request $request)
    {
        $enabled = EventSetting::where('key', 'streaming_enabled')->value('value');
        if ($enabled !== 'true') {
            return view('pages.streaming-disabled');
        }

        $request->validate([
            'ticket_code' => 'required|string|max:20',
        ], [
            'ticket_code.required' => 'Kode tiket wajib diisi.',
        ]);

        $ticketCode = strtoupper(trim($request->ticket_code));

        $order = Order::with('ticketCategory')->where('ticket_code', $ticketCode)->first();

        if (!$order) {
            return back()->withErrors(['ticket_code' => 'Kode tiket tidak ditemukan.'])->withInput();
        }

        if ($order->payment_status !== 'confirmed') {
            return back()->withErrors(['ticket_code' => 'Tiket belum lunas. Silakan selesaikan pembayaran terlebih dahulu.'])->withInput();
        }

        if (!$order->isStreamingTicket()) {
            return back()->withErrors(['ticket_code' => 'Tiket ini bukan tipe streaming. Hanya tiket streaming yang dapat mengakses halaman ini.'])->withInput();
        }

        // Single-device lock: generate new session token, invalidating any previous session
        $token = Str::random(64);

        DB::transaction(function () use ($order, $token) {
            $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();
            $lockedOrder->streaming_session_token = $token;
            $lockedOrder->streaming_session_at = now();
            $lockedOrder->save();
        });

        // Store token + ticket code in the user's browser session
        session([
            'streaming_token' => $token,
            'streaming_ticket_code' => $ticketCode,
        ]);

        return redirect()->route('streaming.watch');
    }

    public function watch()
    {
        $token = session('streaming_token');
        $ticketCode = session('streaming_ticket_code');

        if (!$token || !$ticketCode) {
            return redirect()->route('streaming.index')
                ->withErrors(['ticket_code' => 'Sesi streaming tidak ditemukan. Silakan masukkan kode tiket.']);
        }

        $order = Order::where('ticket_code', $ticketCode)->first();

        if (!$order || $order->streaming_session_token !== $token) {
            // Session has been invalidated (another device logged in)
            session()->forget(['streaming_token', 'streaming_ticket_code']);
            return redirect()->route('streaming.index')
                ->withErrors(['ticket_code' => 'Sesi Anda telah berakhir karena tiket ini digunakan di perangkat lain. Silakan masuk kembali.']);
        }

        $youtubeUrl = EventSetting::where('key', 'youtube_live_url')->value('value');

        // Extract YouTube video ID from URL
        $videoId = $this->extractYoutubeId($youtubeUrl);

        return view('pages.streaming-watch', [
            'order' => $order,
            'videoId' => $videoId,
            'youtubeUrl' => $youtubeUrl,
        ]);
    }

    /**
     * Heartbeat endpoint — verify streaming session is still valid (called via AJAX).
     */
    public function heartbeat(Request $request)
    {
        $token = session('streaming_token');
        $ticketCode = session('streaming_ticket_code');

        if (!$token || !$ticketCode) {
            return response()->json(['valid' => false], 401);
        }

        $order = Order::where('ticket_code', $ticketCode)->first();

        if (!$order || $order->streaming_session_token !== $token) {
            session()->forget(['streaming_token', 'streaming_ticket_code']);
            return response()->json(['valid' => false], 401);
        }

        return response()->json(['valid' => true]);
    }

    public function logout()
    {
        session()->forget(['streaming_token', 'streaming_ticket_code']);
        return redirect()->route('streaming.index');
    }

    /**
     * Extract YouTube video ID from various URL formats.
     */
    private function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Match standard YouTube URL patterns
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|live\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        // If it's already just a video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }
}
