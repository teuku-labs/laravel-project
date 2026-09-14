<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_sidang', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sidang_id')
                ->unique()
                ->constrained('sidangs')
                ->cascadeOnDelete();

            $table->decimal('isi_materi', 5, 2)->nullable();
            $table->decimal('penyajian', 5, 2)->nullable();
            $table->decimal('penguasaan_materi', 5, 2)->nullable();
            $table->decimal('sikap_mental', 5, 2)->nullable();

            $table->decimal('rata_rata', 5, 2)->nullable();
            $table->string('nilai_huruf', 2)->nullable();

            $table->string('dinilai_oleh')->nullable();
            $table->string('dinilai_oleh_role', 20)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_sidang');
    }
};