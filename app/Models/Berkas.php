<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';
    protected $fillable = [
        'mahasiswa_id',
        'nama_seminar',
        'dospem_1',
        'dospem_2',
        'bukti_pembayaran',
        'judul_seminar',
        'file_skripsi'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
