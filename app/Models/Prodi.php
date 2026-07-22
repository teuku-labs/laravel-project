<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kaprodi;
use App\Models\Dekan;

class Prodi extends Model

{
    protected $table = 'prodi';

    protected $fillable = [
        'nama_prodi',
        'kode_prodi'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    public function kaprodi()
    {
        return $this->hasMany(Kaprodi::class);
    }

    public function dekan()
    {
        return $this->hasMany(Dekan::class);
    }
}
