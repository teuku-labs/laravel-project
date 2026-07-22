<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');

            // Disalin dari mahasiswa->pembimbing1_id saat submit, dipakai Kaprodi untuk
            // menampilkan & menjadwalkan seminar (pola yang sama dengan seminar_lkp).
            $table->foreignId('pembimbing1_id')->nullable()->constrained('dosen')->nullOnDelete();

            $table->string('judul');
            $table->string('file_proposal');

            // Diisi Kaprodi saat menjadwalkan seminar proposal (sama seperti seminar_lkp).
            $table->date('tanggal_seminar')->nullable();

            $table->boolean('admin_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};