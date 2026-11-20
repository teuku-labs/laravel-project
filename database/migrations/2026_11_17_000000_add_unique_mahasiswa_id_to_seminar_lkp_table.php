<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Satu mahasiswa hanya boleh punya satu pendaftaran seminar LKP.
     * Sebelumnya hanya dicek di kode (bisa lolos jika klik ganda).
     */
    public function up(): void
    {
        $duplikat = DB::table('seminar_lkp')
            ->select('mahasiswa_id')
            ->groupBy('mahasiswa_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('mahasiswa_id');

        if ($duplikat->isNotEmpty()) {
            throw new RuntimeException(
                'Ada pendaftaran LKP ganda untuk mahasiswa_id: ' . $duplikat->implode(', ')
                . '. Hapus data gandanya dulu, lalu jalankan migrasi lagi.'
            );
        }

        Schema::table('seminar_lkp', function (Blueprint $table) {
            $table->unique('mahasiswa_id', 'seminar_lkp_mahasiswa_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('seminar_lkp', function (Blueprint $table) {
            $table->dropUnique('seminar_lkp_mahasiswa_id_unique');
        });
    }
};