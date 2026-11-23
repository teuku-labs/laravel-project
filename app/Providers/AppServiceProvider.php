<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Kaprodi;
use App\Models\SeminarLkp;
use App\Models\Proposal;
use App\Models\Sidang;
use App\Models\PengajuanPembimbing;

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

        // Sidebar kaprodi: identitas + angka badge "perlu tindakan".
        // Dipasang hanya pada partial sidebar (bukan 'kaprodi.*') supaya query
        // berjalan sekali per halaman, bukan sekali untuk halaman dan sekali
        // lagi untuk partial. Definisi angka sama dengan yang dipakai di
        // dashboard & halaman daftar masing-masing, jadi tidak saling bertentangan.
        View::composer('kaprodi.partials.sidebar', function ($view) {
            if (! Auth::check()) return;

            $kaprodi = Kaprodi::with('prodi')->where('user_id', Auth::id())->first();
            if (! $kaprodi) return;

            $prodiId = $kaprodi->prodi_id;
            $dosenId = (int) (Dosen::where('user_id', Auth::id())->value('id') ?? 0);
            $dariProdi = fn ($q) => $q->where('prodi_id', $prodiId);

            $view->with('sbKaprodi', [
                'nama'  => $kaprodi->nama,
                'prodi' => optional($kaprodi->prodi)->nama_prodi,
            ]);

            $view->with('sbBadge', [
                // belum dijadwalkan
                'seminar'   => SeminarLkp::whereHas('mahasiswa', $dariProdi)->whereNull('tanggal_seminar')->count(),
                'proposal'  => Proposal::whereHas('mahasiswa', $dariProdi)->whereNull('tanggal_seminar')->count(),
                // menunggu keputusan kaprodi (belum disetujui & belum ditolak)
                'sidang'    => Sidang::whereHas('mahasiswa', $dariProdi)
                                ->where('kaprodi_approved', false)
                                ->where('kaprodi_rejected', false)->count(),
                // pengajuan bimbingan yang masih pending untuk kaprodi sebagai dosen
                'bimbingan' => $dosenId
                                ? PengajuanPembimbing::where('dosen_id', $dosenId)->where('status', 'pending')->count()
                                : 0,
            ]);
        });
    }
}