<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    protected $fillable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'judul',
        'file_proposal',
        'tanggal_seminar',
        'admin_verified',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function nilai()
    {
        return $this->hasOne(NilaiProposal::class, 'proposal_id');
    }
}