<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SK Pembahas: dekan mengisi nomor SK dan tanggal SK pada proposal
     * yang kedua pembahasnya sudah ditetapkan kaprodi.
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('nomor_sk_pembahas', 100)->nullable();
            $table->date('tanggal_sk_pembahas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['nomor_sk_pembahas', 'tanggal_sk_pembahas']);
        });
    }
};