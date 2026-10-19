<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi user
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 👤 Info user
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('role')->nullable();

            // 🎯 Aktivitas
            $table->string('aksi')->index(); // ✅ index penting
            $table->text('keterangan')->nullable();

            // 🌐 Info request
            $table->string('ip_address', 45)->nullable(); // IPv6 support
            $table->text('user_agent')->nullable();

            // 🕒 Waktu log
            $table->timestamp('waktu')->useCurrent()->index(); // ✅ default + index

            // ❗ HAPUS timestamps() kalau pakai waktu custom
            // $table->timestamps(); ❌
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};