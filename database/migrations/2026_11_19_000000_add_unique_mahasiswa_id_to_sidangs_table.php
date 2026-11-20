<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Satu mahasiswa hanya boleh punya satu pendaftaran sidang skripsi.
     * Sebelumnya hanya dicek di kode (bisa lolos jika klik ganda).
     */
    public function up(): void
    {
        $duplikat = DB::table('sidangs')
            ->select('mahasiswa_id')
            ->groupBy('mahasiswa_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('mahasiswa_id');

        if ($duplikat->isNotEmpty()) {
            throw new RuntimeException(
                'Ada pendaftaran sidang ganda untuk mahasiswa_id: ' . $duplikat->implode(', ')
                . '. Hapus data gandanya dulu, lalu jalankan migrasi lagi.'
            );
        }

        Schema::table('sidangs', function (Blueprint $table) {
            $table->unique('mahasiswa_id', 'sidangs_mahasiswa_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->dropUnique('sidangs_mahasiswa_id_unique');
        });
    }
};