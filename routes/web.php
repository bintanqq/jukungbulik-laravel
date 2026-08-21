<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\StreamingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::get('/beli-tiket', [TicketController::class, 'index'])->middleware('throttle:60,1')->name('ticket.index');
Route::post('/beli-tiket', [TicketController::class, 'store'])->middleware('throttle:ticket_purchase')->name('ticket.store');

Route::get('/beli-tiket/sukses/{ticketCode}', [TicketController::class, 'success'])->name('ticket.success')->middleware('signed');
Route::get('/beli-tiket/gagal/{ticketCode}', [TicketController::class, 'failed'])->name('ticket.failed')->middleware('signed');

// Xendit payment webhook — CSRF exempt for external callbacks
Route::post('/webhook/xendit', [WebhookController::class, 'xendit'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Sertifikat — Klaim & Download
Route::get('/sertifikat', [CertificateController::class, 'index'])->name('certificate.index');
Route::post('/sertifikat', [CertificateController::class, 'claim'])->middleware('throttle:10,1')->name('certificate.claim');
Route::get('/sertifikat/download/{ticketCode}', [CertificateController::class, 'download'])->name('certificate.download');

// Streaming — Login, Watch, Heartbeat & Logout
Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming.index');
Route::post('/streaming/masuk', [StreamingController::class, 'authenticate'])->middleware('throttle:10,1')->name('streaming.authenticate');
Route::get('/streaming/nonton', [StreamingController::class, 'watch'])->middleware('streaming.session')->name('streaming.watch');
Route::get('/streaming/heartbeat', [StreamingController::class, 'heartbeat'])->middleware('streaming.session')->name('streaming.heartbeat');
Route::post('/streaming/keluar', [StreamingController::class, 'logout'])->name('streaming.logout');
