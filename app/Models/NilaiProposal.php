<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HitungNilaiTrait;

class NilaiProposal extends Model
{
    use HitungNilaiTrait;

    protected $table = 'nilai_proposal';

    protected $fillable = [
        'proposal_id',
        'dosen_id',
        'isi_materi',
        'penyajian',
        'penguasaan_materi',
        'sikap_mental',
        'rata_rata',
        'nilai_huruf',
        'dinilai_oleh',
        'dinilai_oleh_role',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}