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
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->enum('nama_seminar', ['Seminar Kerja Praktik', 'Seminar Proposal','Sidang Skripsi']);
            $table->string('dospem_1');
            $table->string('dospem_2');
            $table->string('bukti_pembayaran');
            $table->string('judul_seminar');
            $table->string('file_skripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
