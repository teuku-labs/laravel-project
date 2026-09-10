<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Jadwal seminar LKP perlu menyimpan jam selesai (waktu + 1 jam 30 menit)
     * agar tampil sebagai rentang "waktu s/d waktu_selesai", bukan cuma
     * jam mulai saja.
     */
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->string('waktu_selesai')->nullable()->after('waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn('waktu_selesai');
        });
    }
};