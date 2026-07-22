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
        Schema::create('pengajuan_sks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('pembimbing1_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('pembimbing2_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->string('nomor_sk')->nullable();
            $table->boolean('admin_verified')->default(false);
            $table->boolean('kaprodi_approved')->default(false);
            $table->boolean('kaprodi_rejected')->default(false);
            $table->text('catatan_kaprodi')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sks');
    }
};