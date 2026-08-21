<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->boolean('is_streaming')->default(false)->after('is_active');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('certificate_name', 100)->nullable()->after('notes');
            $table->string('certificate_code', 30)->nullable()->unique()->after('certificate_name');
            $table->dateTime('certificate_claimed_at')->nullable()->after('certificate_code');
            $table->boolean('certificate_sent_email')->default(false)->after('certificate_claimed_at');
            $table->boolean('certificate_sent_wa')->default(false)->after('certificate_sent_email');
            $table->string('streaming_session_token', 64)->nullable()->after('certificate_sent_wa');
            $table->dateTime('streaming_session_at')->nullable()->after('streaming_session_token');
        });

        // Add new event settings
        DB::table('event_settings')->insertOrIgnore([
            ['key' => 'youtube_live_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'certificate_enabled', 'value' => 'true', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'streaming_enabled', 'value' => 'true', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_name',
                'certificate_code',
                'certificate_claimed_at',
                'certificate_sent_email',
                'certificate_sent_wa',
                'streaming_session_token',
                'streaming_session_at',
            ]);
        });

        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->dropColumn('is_streaming');
        });

        DB::table('event_settings')->whereIn('key', [
            'youtube_live_url',
            'certificate_enabled',
            'streaming_enabled',
        ])->delete();
    }
};
