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

    public function nilai()
    {
        return $this->hasOne(NilaiSidang::class, 'sidang_id');
    }
}