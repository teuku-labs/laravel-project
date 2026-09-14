<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HitungNilaiTrait;

class NilaiSidang extends Model
{
    use HitungNilaiTrait;

    protected $table = 'nilai_sidang';

    protected $fillable = [
        'sidang_id',
        'isi_materi',
        'penyajian',
        'penguasaan_materi',
        'sikap_mental',
        'rata_rata',
        'nilai_huruf',
        'dinilai_oleh',
        'dinilai_oleh_role',
    ];

    public function sidang()
    {
        return $this->belongsTo(Sidang::class, 'sidang_id');
    }
}