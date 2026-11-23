<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alur SK Yudisium baru:
     *  1. Kaprodi memilih mahasiswa yang lulus sidang di prodinya, mengisi IPK (dan
     *     melengkapi tempat/tanggal lahir bila perlu), lalu mengajukan ke dekan.
     *  2. Dekan mengisi nomor dan tanggal SK, sehingga SK terbit.
     *  3. SK (beserta lampiran nama) kembali ke kaprodi untuk dilihat dan diunduh.
     *
     * Karena itu nomor/tanggal SK baru terisi di langkah 2 (nullable), dan SK dimiliki
     * satu prodi. Data per mahasiswa untuk lampiran disimpan di yudisium_sk_mahasiswa.
     */
    public function up(): void
    {
        Schema::table('yudisium_sks', function (Blueprint $table) {
            $table->string('nomor_sk', 100)->nullable()->change();
            $table->date('tanggal_sk')->nullable()->change();

            $table->foreignId('prodi_id')->nullable()->after('id')->constrained('prodi')->nullOnDelete();
            $table->string('status', 20)->default('diajukan')->after('tanggal_sk'); // diajukan | terbit
            $table->timestamp('diajukan_at')->nullable()->after('status');
        });

        // SK yang sudah ada sebelum migrasi ini (alur lama, dekan yang menerbitkan) dianggap terbit.
        DB::table('yudisium_sks')->whereNotNull('nomor_sk')->update(['status' => 'terbit']);

        Schema::create('yudisium_sk_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yudisium_sk_id')->constrained('yudisium_sks')->cascadeOnDelete();
            $table->foreignId('sidang_id')->constrained('sidangs')->cascadeOnDelete();
            $table->decimal('ipk', 3, 2);
            // Salinan tempat/tanggal lahir saat diajukan: bisa dikoreksi kaprodi tanpa mengubah data LKP.
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->timestamps();

            $table->unique('sidang_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yudisium_sk_mahasiswa');

        Schema::table('yudisium_sks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('prodi_id');
            $table->dropColumn(['status', 'diajukan_at']);
        });
    }
};