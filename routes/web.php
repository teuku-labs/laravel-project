<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\Mahasiswa\SeminarLkpController;
use App\Http\Controllers\Mahasiswa\ProposalController;
use App\Http\Controllers\Mahasiswa\SidangController;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        $dashboard = match (\Illuminate\Support\Facades\Auth::user()->role) {
            'admin'     => 'admin.dashboard',
            'mahasiswa' => 'mahasiswa.dashboard',
            'dosen'     => 'dosen.dashboard',
            'kaprodi'   => 'kaprodi.dashboard',
            'dekan'     => 'dekan.dashboard',
            default     => null,
        };
        if ($dashboard) {
            return redirect()->route($dashboard);
        }
    }
    return view('landing');
})->name('landing');
/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',  [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login']);
    Route::get('/register',  [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

    /*
    |----------------------------------------------------------------------
    | ADMIN
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola Dosen (resource sudah ada)
        Route::resource('dosen', \App\Http\Controllers\Admin\DosenController::class);

        // Kelola Kaprodi
        Route::get('/kaprodi',              [AdminController::class, 'kaprodiIndex'])->name('kaprodi.index');
        Route::get('/kaprodi/create',       [AdminController::class, 'kaprodiCreate'])->name('kaprodi.create');
        Route::post('/kaprodi',             [AdminController::class, 'kaprodiStore'])->name('kaprodi.store');
        Route::get('/kaprodi/{id}/edit',    [AdminController::class, 'kaprodiEdit'])->name('kaprodi.edit');
        Route::put('/kaprodi/{id}',         [AdminController::class, 'kaprodiUpdate'])->name('kaprodi.update');
        Route::delete('/kaprodi/{id}',      [AdminController::class, 'kaprodiDestroy'])->name('kaprodi.destroy');

        // Kelola Dekan
        Route::get('/dekan',                [AdminController::class, 'dekanIndex'])->name('dekan.index');
        Route::get('/dekan/create',         [AdminController::class, 'dekanCreate'])->name('dekan.create');
        Route::post('/dekan',               [AdminController::class, 'dekanStore'])->name('dekan.store');
        Route::get('/dekan/{id}/edit',      [AdminController::class, 'dekanEdit'])->name('dekan.edit');
        Route::put('/dekan/{id}',           [AdminController::class, 'dekanUpdate'])->name('dekan.update');
        Route::delete('/dekan/{id}',        [AdminController::class, 'dekanDestroy'])->name('dekan.destroy');

        // Kelola Mahasiswa (view only)
        Route::get('/mahasiswa',            [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
        Route::get('/mahasiswa/{id}',       [AdminController::class, 'mahasiswaShow'])->name('mahasiswa.show');

        // Kelola Seminar LKP
        Route::get('/seminar',              [AdminController::class, 'seminarIndex'])->name('seminar.index');
        Route::get('/seminar/{id}',         [AdminController::class, 'seminarShow'])->name('seminar.show');

        // Placeholder (belum diimplementasi)
        Route::get('/seminar/{id}/edit',    fn($id) => back())->name('seminar.edit');
        // Kelola Sidang
        Route::get('/sidang',               [AdminController::class, 'sidangIndex'])->name('sidang.index');
        Route::get('/sidang/{id}',          [AdminController::class, 'sidangShow'])->name('sidang.show');

        // Kelola Seminar Proposal
        Route::get('/proposal',             [AdminController::class, 'proposalIndex'])->name('proposal.index');
        Route::get('/proposal/{id}',        [AdminController::class, 'proposalShow'])->name('proposal.show');
        
        Route::get('/approval',             fn() => back())->name('approval.index');

        // Profile & Settings
        Route::get('/profile',              [AdminController::class, 'profile'])->name('profile');
        Route::get('/settings',             [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings/password',   [AdminController::class, 'updatePassword'])->name('settings.password');
    });

    /*
    |----------------------------------------------------------------------
    | MAHASISWA
    |----------------------------------------------------------------------
    */
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/mahasiswa',                  [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
        Route::post('/mahasiswa/pilih-dosen',     [MahasiswaController::class, 'pilihDosen'])->name('dosen.pilih');
        Route::post('/mahasiswa/pilih-dosen-lkp', [MahasiswaController::class, 'pilihDosenLkp'])->name('pilih.dosen.lkp');
        Route::post('/lkp/daftar',                [SeminarLkpController::class, 'store'])->name('lkp.daftar');
        Route::post('/proposal/daftar', [ProposalController::class, 'store'])->name('proposal.daftar');
        Route::post('/sidang/daftar',   [SidangController::class, 'store'])->name('sidang.daftar');

        // Profile & Settings mahasiswa
        Route::get('/mahasiswa/profile',            [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');
        Route::post('/mahasiswa/settings/password',  [MahasiswaController::class, 'updatePassword'])->name('mahasiswa.settings.password');
    });

    /*
    |----------------------------------------------------------------------
    | DOSEN
    |----------------------------------------------------------------------
    */
    Route::prefix('dosen')->name('dosen.')->middleware('role:dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::get('/jadwal',    [DosenController::class, 'jadwal'])->name('jadwal');
        Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->name('mahasiswa');
        Route::get('/sk',        [DosenController::class, 'sk'])->name('sk');
        Route::get('/sk/pembimbing/{id}', [DosenController::class, 'skPembimbingUnduh'])->name('sk.pembimbing.unduh');
        Route::get('/sk/pembahas/{id}',   [DosenController::class, 'skPembahasUnduh'])->name('sk.pembahas.unduh');
        Route::get('/profile',   [DosenController::class, 'profile'])->name('profile');
        Route::post('/bimbingan/{id}/approve', [DosenController::class, 'approveBimbingan'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',  [DosenController::class, 'rejectBimbingan'])->name('bimbingan.reject');

        Route::get('/nilai-lkp',            [DosenController::class, 'nilaiLkpIndex'])->name('nilai-lkp.index');
        Route::post('/nilai-lkp/{id}',      [DosenController::class, 'nilaiLkpStore'])->name('nilai-lkp.store');
        Route::get('/nilai-proposal',       [DosenController::class, 'nilaiProposalIndex'])->name('nilai-proposal.index');
        Route::post('/nilai-proposal/{id}', [DosenController::class, 'nilaiProposalStore'])->name('nilai-proposal.store');
        Route::get('/nilai-sidang',         [DosenController::class, 'nilaiSidangIndex'])->name('nilai-sidang.index');
        Route::post('/nilai-sidang/{id}',   [DosenController::class, 'nilaiSidangStore'])->name('nilai-sidang.store');
    });

    /*
    |----------------------------------------------------------------------
    | KAPRODI
    |----------------------------------------------------------------------
    */
    Route::prefix('kaprodi')->name('kaprodi.')->middleware('role:kaprodi')->group(function () {
        Route::get('/dashboard',            [KaprodiController::class, 'dashboard'])->name('dashboard');
        Route::get('/seminar',              [KaprodiController::class, 'seminar'])->name('seminar');
        Route::get('/seminar/{id}',         [KaprodiController::class, 'seminarShow'])->name('seminar.show');
        Route::post('/seminar/{id}/jadwal', [KaprodiController::class, 'seminarJadwal'])->name('seminar.jadwal');
        Route::post('/seminar/{id}/pembimbing', [KaprodiController::class, 'seminarUpdatePembimbing'])->name('seminar.pembimbing');
        Route::post('/seminar/{id}/penguji', [KaprodiController::class, 'seminarUpdatePenguji'])->name('seminar.penguji');
        Route::get('/proposal',              [KaprodiController::class, 'proposalIndex'])->name('proposal.index');
        Route::get('/proposal/{id}',         [KaprodiController::class, 'proposalShow'])->name('proposal.show');
        Route::post('/proposal/{id}/jadwal', [KaprodiController::class, 'proposalJadwal'])->name('proposal.jadwal');
        Route::post('/proposal/{id}/penguji', [KaprodiController::class, 'proposalUpdatePenguji'])->name('proposal.penguji');
        Route::get('/nilai-lkp',                [KaprodiController::class, 'nilaiIndex'])->name('nilai-lkp.index');
        Route::post('/nilai-lkp/{id}',          [KaprodiController::class, 'nilaiStore'])->name('nilai-lkp.store');
        Route::get('/nilai-proposal',            [KaprodiController::class, 'nilaiProposalIndex'])->name('nilai-proposal.index');
        Route::post('/nilai-proposal/{id}',      [KaprodiController::class, 'nilaiProposalStore'])->name('nilai-proposal.store');
        Route::get('/nilai-sidang',              [KaprodiController::class, 'nilaiSidangIndex'])->name('nilai-sidang.index');
        Route::post('/nilai-sidang/{id}',        [KaprodiController::class, 'nilaiSidangStore'])->name('nilai-sidang.store');

        // Teruskan SK Pembimbing + Pembahas ke dekan (setelah seluruh nilai diinput dosen)
        Route::get('/sk-dekan',                 [KaprodiController::class, 'skDekanIndex'])->name('sk-dekan.index');
        Route::post('/sk-dekan/teruskan-semua', [KaprodiController::class, 'skDekanTeruskanSemua'])->name('sk-dekan.teruskan-semua');
        Route::post('/sk-dekan/{id}',           [KaprodiController::class, 'skDekanTeruskan'])->name('sk-dekan.teruskan');

        // SK Yudisium: kaprodi pilih mahasiswa yang lulus sidang + isi IPK -> ajukan ke dekan.
        // Setelah dekan mengisi nomor & tanggal, SK (dengan lampiran nama) kembali ke halaman sk-yudisium.
        Route::get('/yudisium',                 [KaprodiController::class, 'yudisiumIndex'])->name('yudisium.index');
        Route::post('/yudisium',                [KaprodiController::class, 'yudisiumAjukan'])->name('yudisium.ajukan');
        Route::delete('/yudisium/{id}',         [KaprodiController::class, 'yudisiumBatal'])->name('yudisium.batal');
        Route::get('/sk-yudisium',              [KaprodiController::class, 'yudisiumSkIndex'])->name('sk-yudisium.index');
        Route::get('/sk-yudisium/{id}/unduh',   [KaprodiController::class, 'yudisiumSkUnduh'])->name('sk-yudisium.unduh');

        Route::get('/sidang',                [KaprodiController::class, 'sidangIndex'])->name('sidang.index');
        Route::get('/sidang/{id}',           [KaprodiController::class, 'sidangShow'])->name('sidang.show');
        Route::post('/sidang/{id}/approve',  [KaprodiController::class, 'sidangApprove'])->name('sidang.approve');
        Route::post('/sidang/{id}/reject',   [KaprodiController::class, 'sidangReject'])->name('sidang.reject');
        Route::post('/sidang/{id}/penguji',  [KaprodiController::class, 'sidangUpdatePenguji'])->name('sidang.penguji');
        Route::post('/sidang/{id}/jadwal',   [KaprodiController::class, 'sidangJadwal'])->name('sidang.jadwal');

        Route::get('/bimbingan',                [KaprodiController::class, 'bimbinganIndex'])->name('bimbingan.index');
        Route::post('/bimbingan/{id}/approve',  [KaprodiController::class, 'bimbinganApprove'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',   [KaprodiController::class, 'bimbinganReject'])->name('bimbingan.reject');
        Route::get('/jadwal-saya',              [KaprodiController::class, 'jadwalSaya'])->name('jadwal-saya');
        // Download SK milik kaprodi sendiri (saat ditunjuk sebagai pembimbing / pembahas)
        Route::get('/sk-saya',                      [KaprodiController::class, 'skSaya'])->name('sk-saya');
        Route::get('/sk-saya/pembimbing/{id}',      [KaprodiController::class, 'skSayaPembimbingUnduh'])->name('sk-saya.pembimbing.unduh');
        Route::get('/sk-saya/pembahas/{id}',        [KaprodiController::class, 'skSayaPembahasUnduh'])->name('sk-saya.pembahas.unduh');

        Route::get('/profile',              [KaprodiController::class, 'profile'])->name('profile');
    });

    /*
    |----------------------------------------------------------------------
    | DEKAN
    |----------------------------------------------------------------------
    */
    Route::prefix('dekan')->name('dekan.')->middleware('role:dekan')->group(function () {
        Route::get('/dashboard', [DekanController::class, 'dashboard'])->name('dashboard');
        Route::get('/seminar',   [DekanController::class, 'seminar'])->name('seminar');
        Route::get('/jadwal',    [DekanController::class, 'jadwal'])->name('jadwal');
        Route::get('/proposal',  [DekanController::class, 'proposal'])->name('proposal');
        Route::get('/nilai-lkp',     [DekanController::class, 'nilaiIndex'])->name('nilai-lkp.index');
        Route::post('/nilai-lkp/{id}', [DekanController::class, 'nilaiStore'])->name('nilai-lkp.store');
        Route::get('/nilai-proposal', [DekanController::class, 'nilaiProposalIndex'])->name('nilai-proposal.index');
        Route::post('/nilai-proposal/{id}', [DekanController::class, 'nilaiProposalStore'])->name('nilai-proposal.store');
        Route::get('/nilai-sidang',  [DekanController::class, 'nilaiSidangIndex'])->name('nilai-sidang.index');
        Route::post('/nilai-sidang/{id}', [DekanController::class, 'nilaiSidangStore'])->name('nilai-sidang.store');
        Route::get('/sidang',    [DekanController::class, 'sidang'])->name('sidang');
        Route::get('/profile',   [DekanController::class, 'profile'])->name('profile');

        // Download SK milik dekan sendiri (saat ditunjuk sebagai pembimbing / pembahas)
        Route::get('/sk-saya',                 [DekanController::class, 'skSaya'])->name('sk-saya');
        Route::get('/sk-saya/pembimbing/{id}', [DekanController::class, 'skSayaPembimbingUnduh'])->name('sk-saya.pembimbing.unduh');
        Route::get('/sk-saya/pembahas/{id}',   [DekanController::class, 'skSayaPembahasUnduh'])->name('sk-saya.pembahas.unduh');

        // SK Pembimbing (kaprodi sudah setuju -> dekan isi nomor & tanggal SK -> cetak)
        Route::get('/sk-pembimbing',              [DekanController::class, 'skPembimbingIndex'])->name('sk-pembimbing.index');
        Route::post('/sk-pembimbing/{id}',        [DekanController::class, 'skPembimbingSimpan'])->name('sk-pembimbing.simpan');
        Route::get('/sk-pembimbing/{id}/cetak',   [DekanController::class, 'skPembimbingCetak'])->name('sk-pembimbing.cetak');

        // SK Pembahas (kaprodi sudah menetapkan pembahas -> dekan isi nomor & tanggal SK -> cetak)
        Route::get('/sk-pembahas',                [DekanController::class, 'skPembahasIndex'])->name('sk-pembahas.index');
        Route::post('/sk-pembahas/{id}',          [DekanController::class, 'skPembahasSimpan'])->name('sk-pembahas.simpan');
        Route::get('/sk-pembahas/{id}/cetak',     [DekanController::class, 'skPembahasCetak'])->name('sk-pembahas.cetak');

        // SK Yudisium (kolektif): kaprodi mengajukan daftar mahasiswa -> dekan isi nomor & tanggal SK -> cetak
        Route::get('/sk-yudisium',                [DekanController::class, 'skYudisiumIndex'])->name('sk-yudisium.index');
        Route::post('/sk-yudisium/{id}',          [DekanController::class, 'skYudisiumSimpan'])->name('sk-yudisium.simpan');
        Route::get('/sk-yudisium/{id}/cetak',     [DekanController::class, 'skYudisiumCetak'])->name('sk-yudisium.cetak');

        Route::get('/bimbingan',                [DekanController::class, 'bimbinganIndex'])->name('bimbingan.index');
        Route::post('/bimbingan/{id}/approve',  [DekanController::class, 'bimbinganApprove'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',   [DekanController::class, 'bimbinganReject'])->name('bimbingan.reject');
        Route::get('/jadwal-saya',              [DekanController::class, 'jadwalSaya'])->name('jadwal-saya');
    });
});