<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PengajuanSk extends Model
{
    protected $table = 'pengajuan_sks';
    
    protected $fillable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'pembimbing2_id',
        'nomor_sk',
        'admin_verified',
        'kaprodi_approved',
        'kaprodi_rejected',
        'catatan_kaprodi'
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }
    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2_id');
    }
}