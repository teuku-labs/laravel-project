<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alur SK Pembimbing/Pembahas: setelah semua dosen selesai menginput nilai,
     * kaprodi meneruskan ke dekan. Kolom ini menandai kapan SK Pembahas sebuah
     * proposal diteruskan kaprodi ke dekan (SK Pembimbing memakai
     * pengajuan_sks.kaprodi_approved).
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->timestamp('sk_pembahas_diteruskan_at')->nullable();
        });

        // SK Pembahas yang sudah terlanjur terbit tetap tampil di dekan.
        DB::table('proposals')
            ->whereNotNull('nomor_sk_pembahas')
            ->update(['sk_pembahas_diteruskan_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('sk_pembahas_diteruskan_at');
        });
    }
};