<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class TicketVerifier extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Verifikasi Tiket';
    protected string $view = 'filament.pages.ticket-verifier';
    
    public $ticketCode = '';
    public $result = null;

    public function verifyTicket()
    {
        $code = strtoupper(trim($this->ticketCode));

        if (empty($code)) {
            $this->result = null;
            return;
        }

        $order = Order::where('ticket_code', $code)->first();

        if (!$order) {
            $this->result = ['status' => 'not_found', 'message' => '❌ TIDAK VALID: Kode tiket tidak ditemukan'];
            return;
        }

        if ($order->payment_status !== 'confirmed') {
            $this->result = ['status' => 'unpaid', 'message' => '❌ TIDAK VALID: Tiket belum lunas'];
            return;
        }

        if ($order->scan_status === 'scanned') {
            $this->result = [
                'status' => 'already_scanned', 
                'message' => '⚠️ SUDAH DIPAKAI: Tiket ini sudah di-scan pada ' . $order->scanned_at->format('d M Y H:i'),
                'order' => $order
            ];
            return;
        }

        $this->result = [
            'status' => 'valid', 
            'message' => '✅ VALID: Tiket dapat digunakan',
            'order' => $order
        ];
    }

    public function markAsScanned()
    {
        if (!$this->result || !isset($this->result['order'])) {
            return;
        }

        // Re-fetch with lock inside a transaction to prevent double-scan
        // Two staff members scanning the same QR simultaneously would race without this
        $success = DB::transaction(function () {
            $order = Order::where('id', $this->result['order']->id)
                ->lockForUpdate()
                ->first();

            if (!$order || $order->scan_status === 'scanned') {
                return false; // Already scanned by another staff
            }

            $order->scan_status = 'scanned';
            $order->scanned_at = now();
            $order->save();

            return $order;
        });

        if ($success === false) {
            $this->result['status'] = 'already_scanned';
            $this->result['message'] = '⚠️ SUDAH DIPAKAI: Tiket sudah di-scan oleh petugas lain';
        } else {
            $this->result['status'] = 'already_scanned';
            $this->result['message'] = '⚠️ SUDAH DIPAKAI: Tiket ini sudah di-scan pada ' . $success->scanned_at->format('d M Y H:i');
            
            $history = session()->get('scan_history', []);
            array_unshift($history, [
                'code' => $success->ticket_code,
                'time' => now()->format('H:i:s'),
                'status' => 'Berhasil'
            ]);
            session()->put('scan_history', array_slice($history, 0, 10));
        }

        $this->ticketCode = '';
    }
}

