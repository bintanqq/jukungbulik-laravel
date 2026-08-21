<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EventSetting;
use App\Services\CertificateService;
use App\Jobs\SendCertificateEmail;
use App\Jobs\SendCertificateWhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function index()
    {
        $enabled = EventSetting::where('key', 'certificate_enabled')->value('value');
        if ($enabled !== 'true') {
            return view('pages.certificate-disabled');
        }

        return view('pages.certificate-claim');
    }

    public function claim(Request $request)
    {
        $enabled = EventSetting::where('key', 'certificate_enabled')->value('value');
        if ($enabled !== 'true') {
            return view('pages.certificate-disabled');
        }

        $request->validate([
            'ticket_code' => 'required|string|max:20',
            'certificate_name' => 'required|string|max:100|min:3',
        ], [
            'ticket_code.required' => 'Kode tiket wajib diisi.',
            'certificate_name.required' => 'Nama untuk sertifikat wajib diisi.',
            'certificate_name.min' => 'Nama minimal 3 karakter.',
            'certificate_name.max' => 'Nama maksimal 100 karakter.',
        ]);

        $ticketCode = strtoupper(trim($request->ticket_code));

        $order = Order::where('ticket_code', $ticketCode)->first();

        if (!$order) {
            return back()->withErrors(['ticket_code' => 'Kode tiket tidak ditemukan.'])->withInput();
        }

        if ($order->payment_status !== 'confirmed') {
            return back()->withErrors(['ticket_code' => 'Tiket belum lunas. Silakan selesaikan pembayaran terlebih dahulu.'])->withInput();
        }

        // Check if certificate already claimed
        if ($order->hasClaimed()) {
            // Allow re-download
            return view('pages.certificate-claimed', [
                'order' => $order,
                'alreadyClaimed' => true,
            ]);
        }

        // Generate certificate inside a transaction with lock to prevent double claims
        $result = DB::transaction(function () use ($order, $request) {
            $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();

            // Double-check inside transaction
            if ($lockedOrder->hasClaimed()) {
                return 'already_claimed';
            }

            // Generate unique certificate code
            do {
                $certCode = 'CERT-JB2026-' . strtoupper(Str::random(6));
            } while (Order::where('certificate_code', $certCode)->exists());

            $lockedOrder->certificate_name = trim($request->certificate_name);
            $lockedOrder->certificate_code = $certCode;
            $lockedOrder->certificate_claimed_at = now();
            $lockedOrder->save();

            // Generate certificate image
            $service = new CertificateService();
            $service->generate($lockedOrder, $lockedOrder->certificate_name);

            return $lockedOrder;
        });

        if ($result === 'already_claimed') {
            $order->refresh();
            return view('pages.certificate-claimed', [
                'order' => $order,
                'alreadyClaimed' => true,
            ]);
        }

        // Dispatch email & WA notification jobs
        SendCertificateEmail::dispatch($result)->onQueue('emails');
        SendCertificateWhatsApp::dispatch($result)->onQueue('notifications');

        return view('pages.certificate-claimed', [
            'order' => $result,
            'alreadyClaimed' => false,
        ]);
    }

    public function download($ticketCode)
    {
        $order = Order::where('ticket_code', strtoupper(trim($ticketCode)))->firstOrFail();

        if (!$order->hasClaimed()) {
            abort(404, 'Sertifikat belum diklaim.');
        }

        $filePath = storage_path('app/certificates/' . $order->ticket_code . '.png');

        if (!file_exists($filePath)) {
            // Re-generate if file is missing
            $service = new CertificateService();
            $service->generate($order, $order->certificate_name);
        }

        return response()->download($filePath, 'Sertifikat-' . $order->certificate_name . '.png');
    }
}
