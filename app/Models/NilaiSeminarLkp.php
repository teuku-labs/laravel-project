<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HitungNilaiTrait;

class NilaiSeminarLkp extends Model
{
    use HitungNilaiTrait;

    protected $table = 'nilai_seminar_lkp';

    protected $fillable = [
        'seminar_lkp_id',
        'isi_materi',
        'penyajian',
        'penguasaan_materi',
        'sikap_mental',
        'rata_rata',
        'nilai_huruf',
        'dinilai_oleh',
        'dinilai_oleh_role',
    ];

    public function seminarLkp()
    {
        return $this->belongsTo(SeminarLkp::class, 'seminar_lkp_id');
    }
}