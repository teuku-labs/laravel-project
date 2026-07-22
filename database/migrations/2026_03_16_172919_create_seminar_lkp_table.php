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
        Schema::create('seminar_lkp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswa')
                ->cascadeOnDelete();

            $table->string('email');
            $table->string('nik_ktp');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_hp');

            $table->string('judul_lkp');

           $table->foreignId('pembimbing1_id')
                ->nullable()
                ->constrained('dosen')
                ->nullOnDelete();

            $table->string('file_laporan');
            $table->string('bukti_transfer');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_lkp');
    }
};
