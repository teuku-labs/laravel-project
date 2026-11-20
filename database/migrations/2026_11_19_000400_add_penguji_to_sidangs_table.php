<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sidang skripsi punya dua dosen pembahas/penguji yang ditetapkan kaprodi
     * (terpisah dari dosen pembimbing). Pola sama dengan proposals.penguji1_id/penguji2_id.
     */
    public function up(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->foreignId('penguji1_id')
                ->nullable()
                ->after('pembimbing_id')
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
        Schema::table('sidangs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('penguji2_id');
            $table->dropConstrainedForeignId('penguji1_id');
        });
    }
};