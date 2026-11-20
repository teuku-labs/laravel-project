<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sidang skripsi tidak lagi melewati verifikasi admin.
     * Pendaftaran lama yang masih "belum diverifikasi" ikut diteruskan ke Kaprodi,
     * dan pendaftaran baru otomatis dianggap diteruskan.
     */
    public function up(): void
    {
        DB::table('sidangs')->where('admin_verified', false)->update(['admin_verified' => true]);

        Schema::table('sidangs', function (Blueprint $table) {
            $table->boolean('admin_verified')->default(true)->change();
        });
    }

    public function down(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->boolean('admin_verified')->default(false)->change();
        });
    }
};