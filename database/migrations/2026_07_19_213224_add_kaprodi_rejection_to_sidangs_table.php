<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Sidang sudah punya admin_verified & kaprodi_approved, tapi belum punya
     * kolom untuk kaprodi_rejected + catatan_kaprodi seperti di tabel
     * pengajuan_sks. Tanpa ini, kaprodi tidak bisa menolak pengajuan sidang
     * dengan alasan yang tercatat.
     */
    public function up(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->boolean('kaprodi_rejected')->default(false)->after('kaprodi_approved');
            $table->text('catatan_kaprodi')->nullable()->after('kaprodi_rejected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->dropColumn(['kaprodi_rejected', 'catatan_kaprodi']);
        });
    }
};