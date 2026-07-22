<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sk extends Model
{
    protected $table = 'sks';

    protected $fillable = [
        'dosen_id',
        'nomor_sk',
        'judul',
        'status',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}