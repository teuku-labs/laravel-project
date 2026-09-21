<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jadwal;

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

        // FIX: badge jumlah "Jadwal Saya" & "Mahasiswa Bimbingan" di sidebar
        // dosen sebelumnya hanya dihitung manual di sebagian controller
        // (dashboard, jadwal, sk, mahasiswa), jadi hilang/tidak konsisten di
        // halaman lain (nilai-lkp, nilai-proposal, nilai-sidang, profile).
        // Dengan view composer ini, semua halaman dosen.* otomatis dapat
        // angka yang sama tanpa perlu diulang di tiap method controller.
        View::composer('dosen.*', function ($view) {
            if (! Auth::check()) return;

            $dosen = Dosen::where('user_id', Auth::id())->first();
            if (! $dosen) return;

            $view->with('mahasiswaCount', Mahasiswa::where('pembimbing1_id', $dosen->id)
                ->orWhere('pembimbing2_id', $dosen->id)->count());

            $view->with('upcomingJadwal', Jadwal::where('dosen_id', $dosen->id)
                ->where('tanggal', '>=', now())->count());
        });
    }
}