<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // FIX: model sebelumnya kosong (tanpa $fillable & relasi), padahal
    // sudah dipakai di beberapa controller:
    // - KaprodiController::updateOrCreate() butuh $fillable
    // - DekanController & AdminController panggil ->with(['mahasiswa','dosen'])
    //   yang sebelumnya akan error "method mahasiswa()/dosen() does not exist"
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'tanggal',
        'waktu',
        'waktu_selesai',
        'ruang',
        'jenis',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Helper query scope, dipakai di beberapa tempat untuk jadwal mendatang
    // (mis. dashboard dosen/dekan yang butuh "jadwal terdekat").
    public function scopeMendatang($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString());
    }

    // 'jenis' cuma berisi lkp/proposal/sidang (lihat enum di migration) —
    // helper ini dipakai buat filter per jenis seminar di dashboard.
    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}