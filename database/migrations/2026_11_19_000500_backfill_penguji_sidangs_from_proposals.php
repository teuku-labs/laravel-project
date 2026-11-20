<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Dosen pembahas sidang skripsi otomatis sama dengan pembahas seminar proposal.
     * Sidang lama yang pembahasnya masih kosong diisi dari proposal mahasiswa yang sama.
     * Pembahas yang sudah ditetapkan kaprodi tidak ditimpa.
     */
    public function up(): void
    {
        $sidangs = DB::table('sidangs')
            ->whereNull('penguji1_id')
            ->whereNull('penguji2_id')
            ->get(['id', 'mahasiswa_id']);

        foreach ($sidangs as $sidang) {
            $proposal = DB::table('proposals')
                ->where('mahasiswa_id', $sidang->mahasiswa_id)
                ->first(['penguji1_id', 'penguji2_id']);

            if ($proposal && ($proposal->penguji1_id || $proposal->penguji2_id)) {
                DB::table('sidangs')->where('id', $sidang->id)->update([
                    'penguji1_id' => $proposal->penguji1_id,
                    'penguji2_id' => $proposal->penguji2_id,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Data hasil salin tidak bisa dibedakan dari yang ditetapkan kaprodi, jadi tidak dibatalkan.
    }
};