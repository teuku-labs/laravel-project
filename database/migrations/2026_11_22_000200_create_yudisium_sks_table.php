<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SK Yudisium bersifat kolektif: satu SK memuat banyak mahasiswa yang lulus sidang.
     * Mahasiswa tidak mengajukan; dekan memilih mahasiswa yang lulus, mengisi nomor dan
     * tanggal SK, lalu menerbitkan. Setiap sidang ditautkan ke SK-nya lewat yudisium_sk_id.
     */
    public function up(): void
    {
        Schema::create('yudisium_sks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sk', 100)->unique();
            $table->date('tanggal_sk');
            $table->timestamps();
        });

        Schema::table('sidangs', function (Blueprint $table) {
            $table->foreignId('yudisium_sk_id')
                ->nullable()
                ->constrained('yudisium_sks')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('yudisium_sk_id');
        });

        Schema::dropIfExists('yudisium_sks');
    }
};