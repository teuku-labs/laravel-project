<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {

            $table->foreignId('dosen_id')
                  ->nullable() // boleh kosong dulu
                  ->constrained('dosen') // relasi ke tabel dosen
                  ->onDelete('set null'); // kalau dosen dihapus, jadi null

        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']);
            $table->dropColumn('dosen_id');
        });
    }
};