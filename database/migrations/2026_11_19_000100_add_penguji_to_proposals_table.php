<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Seminar proposal punya dua dosen pembahas/penguji yang ditetapkan kaprodi
     * (terpisah dari dosen pembimbing). Pola sama dengan seminar_lkp.penguji_id.
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->foreignId('penguji1_id')
                ->nullable()
                ->after('pembimbing1_id')
                ->constrained('dosen')
                ->nullOnDelete();

            $table->foreignId('penguji2_id')
                ->nullable()
                ->after('penguji1_id')
                ->constrained('dosen')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('penguji2_id');
            $table->dropConstrainedForeignId('penguji1_id');
        });
    }
};