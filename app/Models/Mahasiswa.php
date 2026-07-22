<?php
// FIX: file ini menggantikan app/Models/Mahasiswa.php
// Perubahan: tambah relasi proposal() dan sidang() supaya bisa dicek status
// pendaftaran mahasiswa (dipakai MahasiswaController::dashboard()).

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
    'user_id',
    'prodi_id',
    'nim',
    'nama',
    'angkatan',
    'pembimbing1_id',
    'pembimbing2_id',
    'pembimbing_lkp_id', // FIX: sebelumnya tidak ada di $fillable padahal dipakai di MahasiswaController::pilihDosenLkp() -> mass assignment akan diabaikan diam-diam kalau dipakai via create()/fill(); di sini masih aman karena kode aslinya set properti langsung + save(), tapi lebih konsisten kalau ikut didaftarkan.
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class);
    }

    public function pengajuanPembimbing()
    {
        return $this->hasMany(PengajuanPembimbing::class);
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2_id');
    }

    public function seminarLkp()
    {
        return $this->hasOne(SeminarLkp::class);
    }

    public function pembimbingLkp()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_lkp_id');
    }

    // BARU
    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }

    // BARU
    public function sidang()
    {
        return $this->hasOne(Sidang::class);
    }
}