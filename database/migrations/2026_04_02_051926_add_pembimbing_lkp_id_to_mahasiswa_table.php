<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreignId('pembimbing_lkp_id')
                  ->nullable()
                  ->constrained('dosen')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['pembimbing_lkp_id']);
            $table->dropColumn('pembimbing_lkp_id');
        });
    }
};
