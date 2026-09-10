<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarLkp extends Model
{
    protected $table = 'seminar_lkp';

    protected $fillable = [
        'mahasiswa_id',
        'email',
        'nik_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'judul_lkp',
        'pembimbing1_id',
        'penguji_id',
        'file_laporan',
        'bukti_transfer',
        'tanggal_seminar'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function penguji()
    {
        return $this->belongsTo(Dosen::class, 'penguji_id');
    }
}