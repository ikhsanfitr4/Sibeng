<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            $table->string('no_order')->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggans');
            $table->foreignId('kendaraan_id')->constrained('kendaraans');
            $table->foreignId('mekanik_id')->constrained('mekaniks');
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->enum('status', ['antrian', 'proses', 'selesai', 'batal'])->default('antrian');
            $table->decimal('biaya_jasa', 12, 2)->default(0);
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};