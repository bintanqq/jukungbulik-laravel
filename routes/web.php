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

Route::middleware(['throttle:5,1'])->group(function () {
    Route::get('/beli-tiket', [TicketController::class, 'index'])->name('ticket.index');
    Route::post('/beli-tiket', [TicketController::class, 'store'])->name('ticket.store');
});

Route::get('/beli-tiket/sukses/{ticketCode}', [TicketController::class, 'success'])->name('ticket.success');
Route::get('/beli-tiket/gagal/{ticketCode}', [TicketController::class, 'failed'])->name('ticket.failed');

// Note: In Laravel 11/13, exempting from CSRF can be done here or in bootstrap/app.php
Route::post('/webhook/xendit', [WebhookController::class, 'xendit'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
