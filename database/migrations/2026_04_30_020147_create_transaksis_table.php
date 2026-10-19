<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('servis_id')->constrained('servis');
            $table->decimal('total_jasa', 12, 2)->default(0);
            $table->decimal('total_parts', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->decimal('bayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])->default('tunai');
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};