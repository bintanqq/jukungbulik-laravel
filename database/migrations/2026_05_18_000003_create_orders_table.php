<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code', 20)->unique();
            $table->string('nama', 100);
            $table->string('whatsapp', 20);
            $table->string('email', 150);
            $table->foreignId('ticket_category_id')->constrained('ticket_categories');
            $table->foreignId('presale_period_id')->constrained('presale_periods');
            $table->unsignedTinyInteger('quantity');
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('total_price');
            $table->enum('payment_status', ['pending', 'confirmed', 'cancelled', 'expired'])->default('pending');
            $table->string('xendit_invoice_id', 100)->nullable();
            $table->text('xendit_invoice_url')->nullable();
            $table->string('xendit_payment_method', 50)->nullable();
            $table->dateTime('payment_confirmed_at')->nullable();
            $table->enum('scan_status', ['unused', 'scanned'])->default('unused');
            $table->dateTime('scanned_at')->nullable();
            $table->boolean('wa_sent')->default(false);
            $table->dateTime('wa_sent_at')->nullable();
            $table->boolean('email_sent')->default(false);
            $table->dateTime('email_sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('ordered_at')->useCurrent();
            $table->timestamps();

            $table->index('payment_status');
            $table->index('scan_status');
            $table->index('whatsapp');
            $table->index('email');
            $table->index('ticket_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
