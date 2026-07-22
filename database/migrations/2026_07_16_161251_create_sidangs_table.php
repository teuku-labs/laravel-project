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
        Schema::create('sidangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->string('judul_skripsi')->nullable();
            $table->foreignId('pembimbing_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->date('tanggal_sidang')->nullable();
            $table->string('file_draft')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->boolean('admin_verified')->default(false);
            $table->boolean('kaprodi_approved')->default(false);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidangs');
    }
};