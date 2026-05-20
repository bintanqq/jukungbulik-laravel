<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebhookController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::get('/beli-tiket', [TicketController::class, 'index'])->middleware('throttle:60,1')->name('ticket.index');
Route::post('/beli-tiket', [TicketController::class, 'store'])->middleware('throttle:ticket_purchase')->name('ticket.store');

Route::get('/beli-tiket/sukses/{ticketCode}', [TicketController::class, 'success'])->name('ticket.success');
Route::get('/beli-tiket/gagal/{ticketCode}', [TicketController::class, 'failed'])->name('ticket.failed');

// Xendit payment webhook — CSRF exempt for external callbacks
Route::post('/webhook/xendit', [WebhookController::class, 'xendit'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

