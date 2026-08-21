<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseTicketRequest;
use App\Models\Order;
use App\Models\PresalePeriod;
use App\Models\TicketCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class TicketController extends Controller
{
    public function index()
    {
        $categories = TicketCategory::where('is_active', true)->get();
        $period = PresalePeriod::where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('is_active', true)
            ->first();
        return view('pages.ticket', compact('categories', 'period'));
    }

    public function store(PurchaseTicketRequest $request)
    {
        // All quota checks and order creation inside a transaction with row locking
        // to prevent race conditions that could cause overselling
        $order = DB::transaction(function () use ($request) {
            // Lock the category row to prevent concurrent reads of stale sold count
            $category = TicketCategory::lockForUpdate()->findOrFail($request->category_id);

            $remaining = $category->quota - $category->sold;
            if ($remaining < $request->quantity) {
                return null; // Will be handled below
            }

            $period = PresalePeriod::where('starts_at', '<=', now())
                ->where('ends_at', '>=', now())
                ->where('is_active', true)
                ->first();

            if (!$period) {
                return false; // Will be handled below
            }

            do {
                $ticketCode = 'JB2026-' . strtoupper(Str::random(12));
            } while (Order::where('ticket_code', $ticketCode)->exists());

            // Price is ALWAYS calculated server-side from DB values — never from user input
            $unitPrice = $category->base_price * (1 - $period->discount / 100);
            $totalPrice = round($unitPrice) * $request->quantity;

            $order = Order::create([
                'ticket_code'        => $ticketCode,
                'nama'               => $request->nama,
                'whatsapp'           => $request->whatsapp,
                'email'              => $request->email,
                'ticket_category_id' => $category->id,
                'presale_period_id'  => $period->id,
                'quantity'           => $request->quantity,
                'unit_price'         => round($unitPrice),
                'total_price'        => $totalPrice,
            ]);

            return $order;
        });

        // Handle transaction results
        if ($order === null) {
            return back()->withErrors(['quantity' => 'Kuota tidak cukup'])->withInput();
        }
        if ($order === false) {
            return back()->withErrors(['period' => 'Tidak ada periode penjualan aktif'])->withInput();
        }

        try {
            Configuration::setXenditKey(config('services.xendit.secret_key'));

            // SSL bypass only in local development — production always verifies
            $client = null;
            if (app()->environment('local') && config('app.debug')) {
                $client = new \GuzzleHttp\Client([
                    'verify' => false,
                ]);
            }

            $category = $order->ticketCategory;

            $apiInstance = new InvoiceApi($client);
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => $order->ticket_code,
                'amount' => $order->total_price,
                'payer_email' => $order->email,
                'description' => "Tiket {$category->name} x{$order->quantity} - JUKUNG BULIK",
                'customer' => [
                    'given_names' => $order->nama,
                    'mobile_number' => '+62' . substr($order->whatsapp, 1),
                    'email' => $order->email,
                ],
                'items' => [[
                    'name' => "Tiket {$category->name} - JUKUNG BULIK",
                    'quantity' => $order->quantity,
                    'price' => $order->unit_price,
                ]],
                'invoice_duration' => 86400,
                'success_redirect_url' => URL::signedRoute('ticket.success', ['ticketCode' => $order->ticket_code]),
                'failure_redirect_url' => URL::signedRoute('ticket.failed', ['ticketCode' => $order->ticket_code]),
            ]);

            $invoice = $apiInstance->createInvoice($createInvoiceRequest);

            $order->xendit_invoice_id = $invoice['id'];
            $order->xendit_invoice_url = $invoice['invoice_url'];
            $order->save();

            return redirect($invoice['invoice_url']);
        } catch (\Exception $e) {
            Log::error('Xendit Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal membuat tagihan pembayaran. Silakan coba lagi.'])->withInput();
        }
    }

    public function success($ticketCode)
    {
        $order = Order::where('ticket_code', $ticketCode)->firstOrFail();
        return view('pages.success', compact('order'));
    }

    public function failed($ticketCode)
    {
        $order = Order::where('ticket_code', $ticketCode)->firstOrFail();
        return view('pages.failed', compact('order'));
    }
}
