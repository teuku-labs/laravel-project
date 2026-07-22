<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class PengajuanPembimbing extends Model
{
    protected $table = 'pengajuan_pembimbings';
    
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'status',
        'catatan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
