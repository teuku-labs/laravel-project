<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kaprodi perlu menentukan dosen pembahas/penguji untuk seminar LKP
     * mahasiswa, terpisah dari dosen pembimbing (pembimbing1_id).
     */
    public function up(): void
    {
        Schema::table('seminar_lkp', function (Blueprint $table) {
            $table->foreignId('penguji_id')
                ->nullable()
                ->after('pembimbing1_id')
                ->constrained('dosen')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar_lkp', function (Blueprint $table) {
            $table->dropConstrainedForeignId('penguji_id');
        });
    }
};