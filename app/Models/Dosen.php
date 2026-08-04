<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    
    protected $fillable = [
    'user_id',
    'prodi_id',
    'nuptk',
    'nama'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'pembimbing1_id');
    }

    public function mahasiswaPembimbing1()
    {
        return $this->hasMany(Mahasiswa::class, 'pembimbing1_id');
    }

    public function mahasiswaPembimbing2()
    {
        return $this->hasMany(Mahasiswa::class, 'pembimbing2_id');
    }

    public function pengajuanPembimbing()
    {
        return $this->hasMany(PengajuanPembimbing::class);
    }

    public function sk()
    {
        return $this->hasMany(Sk::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

}