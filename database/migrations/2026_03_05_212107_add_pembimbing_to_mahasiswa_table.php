<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {

            // cek apakah kolom dosen_id ada
            if (Schema::hasColumn('mahasiswa', 'dosen_id')) {

                try {
                    $table->dropForeign(['dosen_id']);
                } catch (\Exception $e) {
                    // jika foreign key tidak ada, abaikan
                }

                $table->dropColumn('dosen_id');
            }

            // tambah pembimbing jika belum ada
            if (!Schema::hasColumn('mahasiswa', 'pembimbing1_id')) {
                $table->foreignId('pembimbing1_id')
                    ->nullable()
                    ->constrained('dosen')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('mahasiswa', 'pembimbing2_id')) {
                $table->foreignId('pembimbing2_id')
                    ->nullable()
                    ->constrained('dosen')
                    ->nullOnDelete();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {

            $table->dropForeign(['pembimbing1_id']);
            $table->dropForeign(['pembimbing2_id']);

            $table->dropColumn([
                'pembimbing1_id',
                'pembimbing2_id'
            ]);

            // kembalikan kolom dosen_id jika rollback
            $table->foreignId('dosen_id')
                ->nullable()
                ->constrained('dosen')
                ->nullOnDelete();
        });
    }
};
