<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Seminar proposal dan sidang skripsi punya dua penguji. Sebelumnya tabel nilai
     * hanya boleh satu baris per proposal/sidang, sehingga nilai penguji yang
     * menyimpan lebih dulu tertimpa penguji berikutnya.
     *
     * Sekarang satu baris per (proposal/sidang, dosen penguji).
     */
    public function up(): void
    {
        $this->ubah('nilai_proposal', 'proposal_id', 'proposals');
        $this->ubah('nilai_sidang', 'sidang_id', 'sidangs');
    }

    public function down(): void
    {
        $this->kembalikan('nilai_proposal', 'proposal_id');
        $this->kembalikan('nilai_sidang', 'sidang_id');
    }

    private function ubah(string $tabel, string $fk, string $tabelInduk): void
    {
        Schema::table($tabel, function (Blueprint $table) use ($fk) {
            $table->foreignId('dosen_id')
                ->nullable()
                ->after($fk)
                ->constrained('dosen')
                ->nullOnDelete();
        });

        // Isi dosen_id untuk nilai lama: cocokkan nama penilai dengan penguji 1/2,
        // kalau tidak cocok anggap milik penguji pertama yang terdaftar.
        foreach (DB::table($tabel)->whereNull('dosen_id')->get() as $baris) {
            $induk = DB::table($tabelInduk)->where('id', $baris->{$fk})->first();
            if (!$induk) {
                continue;
            }

            $idPenguji = array_values(array_filter([$induk->penguji1_id, $induk->penguji2_id]));
            $dosenId = null;

            if ($baris->dinilai_oleh && $idPenguji) {
                $dosenId = DB::table('dosen')
                    ->whereIn('id', $idPenguji)
                    ->where('nama', $baris->dinilai_oleh)
                    ->value('id');
            }

            $dosenId = $dosenId ?? ($idPenguji[0] ?? null);

            if ($dosenId) {
                DB::table($tabel)->where('id', $baris->id)->update(['dosen_id' => $dosenId]);
            }
        }

        // Unique gabungan dibuat DULU sebelum unique lama dihapus, karena foreign key
        // pada kolom induk membutuhkan minimal satu index yang tetap ada.
        Schema::table($tabel, function (Blueprint $table) use ($fk) {
            $table->unique([$fk, 'dosen_id']);
        });
        Schema::table($tabel, function (Blueprint $table) use ($fk) {
            $table->dropUnique([$fk]);
        });
    }

    private function kembalikan(string $tabel, string $fk): void
    {
        // Sebelum 1 baris per induk dipulihkan, simpan hanya nilai yang paling baru.
        $simpan = DB::table($tabel)->selectRaw("MAX(id) as id")->groupBy($fk)->pluck('id');
        DB::table($tabel)->whereNotIn('id', $simpan)->delete();

        Schema::table($tabel, function (Blueprint $table) use ($fk) {
            $table->unique([$fk]);
        });
        Schema::table($tabel, function (Blueprint $table) use ($fk) {
            $table->dropUnique([$fk, 'dosen_id']);
        });
        Schema::table($tabel, function (Blueprint $table) {
            $table->dropConstrainedForeignId('dosen_id');
        });
    }
};