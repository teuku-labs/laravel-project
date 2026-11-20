<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sidang extends Model
{
    protected $table = 'sidangs';
    protected $fillable = [
        'mahasiswa_id',
        'judul_skripsi',
        'pembimbing_id',
        'penguji1_id',
        'penguji2_id',
        'tanggal_sidang',
        'file_draft',
        'file_bebas_pustaka',
        'bukti_transfer',
        'admin_verified',
        'kaprodi_approved',
        'kaprodi_rejected',
        'catatan_kaprodi',
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function pembimbing()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_id');
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
        return $this->hasOne(NilaiSidang::class, 'sidang_id');
    }

    /**
     * Dosen yang boleh menginput nilai sidang skripsi ini:
     * hanya dua dosen pembahas/penguji. Dosen pembimbing tidak menilai
     * (sama dengan aturan Proposal::bolehDinilaiOleh()).
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
}