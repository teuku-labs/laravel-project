<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposals';

    protected $fillable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'penguji1_id',
        'penguji2_id',
        'judul',
        'file_proposal',
        'tanggal_seminar',
        'admin_verified',
    ];

    protected $casts = [
        'admin_verified' => 'boolean',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function penguji1()
    {
        return $this->belongsTo(Dosen::class, 'penguji1_id');
    }

    public function penguji2()
    {
        return $this->belongsTo(Dosen::class, 'penguji2_id');
    }

    public function nilai()
    {
        return $this->hasOne(NilaiProposal::class, 'proposal_id');
    }

    /**
     * Dosen yang boleh menginput nilai seminar proposal ini:
     * hanya dua dosen pembahas/penguji. Dosen pembimbing tidak menilai.
     */
    public function bolehDinilaiOleh(?Dosen $dosen): bool
    {
        if (!$dosen) {
            return false;
        }

        return in_array($dosen->id, array_filter([
            $this->penguji1_id,
            $this->penguji2_id,
        ]));
    }

    /**
     * Seminar Proposal dinyatakan lulus jika nilainya sudah diinput dan bukan E
     * (rata-rata >= 50, sama dengan aturan SeminarLkp::lulus()).
     */
    public function lulus(): bool
    {
        $nilai = $this->nilai;

        return $nilai !== null && (float) $nilai->rata_rata >= 50;
    }
}