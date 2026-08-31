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

Route::get('/', fn() => redirect()->route('login'));

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
        Route::post('/sidang/{id}/verify',  [AdminController::class, 'sidangVerify'])->name('sidang.verify');
        
        // Kelola SK Pembimbing
        Route::get('/sk-pembimbing',        [AdminController::class, 'skPembimbingIndex'])->name('sk-pembimbing.index');
        Route::get('/sk-pembimbing/{id}/edit', [AdminController::class, 'skPembimbingEdit'])->name('sk-pembimbing.edit');
        Route::put('/sk-pembimbing/{id}',   [AdminController::class, 'skPembimbingUpdate'])->name('sk-pembimbing.update');
        Route::get('/sk-pembimbing/{id}',   [AdminController::class, 'skPembimbingShow'])->name('sk-pembimbing.show');
        Route::post('/sk-pembimbing/{id}/approval', [AdminController::class, 'skPembimbingSubmitApproval'])->name('sk-pembimbing.submit-approval');
        
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
        Route::post('/sk/ajukan', [MahasiswaController::class, 'ajukanSk'])->name('sk.ajukan');

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
        Route::get('/profile',   [DosenController::class, 'profile'])->name('profile');
        Route::post('/bimbingan/{id}/approve', [DosenController::class, 'approveBimbingan'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',  [DosenController::class, 'rejectBimbingan'])->name('bimbingan.reject');
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
        Route::get('/sk-pembimbing',            [KaprodiController::class, 'skPembimbingIndex'])->name('sk-pembimbing.index');
        Route::get('/sk-pembimbing/{id}',       [KaprodiController::class, 'skPembimbingShow'])->name('sk-pembimbing.show');
        Route::post('/sk-pembimbing/{id}/approve', [KaprodiController::class, 'skPembimbingApprove'])->name('sk-pembimbing.approve');
        Route::post('/sk-pembimbing/{id}/reject',  [KaprodiController::class, 'skPembimbingReject'])->name('sk-pembimbing.reject');

        Route::get('/sidang',                [KaprodiController::class, 'sidangIndex'])->name('sidang.index');
        Route::get('/sidang/{id}',           [KaprodiController::class, 'sidangShow'])->name('sidang.show');
        Route::post('/sidang/{id}/approve',  [KaprodiController::class, 'sidangApprove'])->name('sidang.approve');
        Route::post('/sidang/{id}/reject',   [KaprodiController::class, 'sidangReject'])->name('sidang.reject');

        Route::get('/bimbingan',                [KaprodiController::class, 'bimbinganIndex'])->name('bimbingan.index');
        Route::post('/bimbingan/{id}/approve',  [KaprodiController::class, 'bimbinganApprove'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',   [KaprodiController::class, 'bimbinganReject'])->name('bimbingan.reject');
        Route::get('/jadwal-saya',              [KaprodiController::class, 'jadwalSaya'])->name('jadwal-saya');

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
        Route::get('/sidang',    [DekanController::class, 'sidang'])->name('sidang');
        Route::get('/profile',   [DekanController::class, 'profile'])->name('profile');

        Route::get('/bimbingan',                [DekanController::class, 'bimbinganIndex'])->name('bimbingan.index');
        Route::post('/bimbingan/{id}/approve',  [DekanController::class, 'bimbinganApprove'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',   [DekanController::class, 'bimbinganReject'])->name('bimbingan.reject');
        Route::get('/jadwal-saya',              [DekanController::class, 'jadwalSaya'])->name('jadwal-saya');
    });
});

