<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Seminar proposal tidak lagi melewati verifikasi admin.
     * Pendaftaran lama yang masih "belum diverifikasi" ikut diteruskan ke Kaprodi,
     * dan pendaftaran baru otomatis dianggap diteruskan.
     */
    public function up(): void
    {
        DB::table('proposals')->where('admin_verified', false)->update(['admin_verified' => true]);

        Schema::table('proposals', function (Blueprint $table) {
            $table->boolean('admin_verified')->default(true)->change();
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->boolean('admin_verified')->default(false)->change();
        });
    }
};