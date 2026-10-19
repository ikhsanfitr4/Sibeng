
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('modul')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn([
                'modul',
                'lokasi',
                'browser',
                'os',
            ]);
        });
    }
};
