<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SK Pembimbing: dekan mengisi nomor SK dan tanggal SK.
     * Peran admin dihapus dari alur SK, jadi semua pengajuan lama
     * yang masih menunggu verifikasi admin dianggap sudah diverifikasi
     * supaya langsung muncul di kaprodi.
     */
    public function up(): void
    {
        Schema::table('pengajuan_sks', function (Blueprint $table) {
            $table->date('tanggal_sk')->nullable()->after('nomor_sk');
        });

        DB::table('pengajuan_sks')->update(['admin_verified' => true]);
    }

    public function down(): void
    {
        Schema::table('pengajuan_sks', function (Blueprint $table) {
            $table->dropColumn('tanggal_sk');
        });
    }
};