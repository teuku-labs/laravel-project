<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FIX: `php artisan storage:link` tidak selalu sempat dijalankan saat
        // deploy (misalnya di hosting yang hanya upload file via FTP/zip tanpa
        // composer script, atau symlink hilang saat sinkronisasi ulang).
        // Tanpa link ini, file yang diupload mahasiswa/dosen (laporan LKP,
        // bukti transfer, proposal, dsb) tersimpan di storage/app/public
        // tapi tidak bisa diakses lewat URL public/storage sehingga tidak
        // tampil di halaman. Sebagai jaring pengaman, link dibuat otomatis
        // saat aplikasi boot kalau belum ada.
        $link   = public_path('storage');
        $target = storage_path('app/public');

        if (! File::exists($link) && ! is_link($link) && File::isDirectory($target)) {
            File::link($target, $link);
        }
    }
}