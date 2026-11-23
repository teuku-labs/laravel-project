<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Satu baris lampiran SK Yudisium: data seorang mahasiswa yang diajukan kaprodi. */
class YudisiumSkMahasiswa extends Model
{
    protected $table = 'yudisium_sk_mahasiswa';

    protected $fillable = ['yudisium_sk_id', 'sidang_id', 'ipk', 'tempat_lahir', 'tanggal_lahir'];

    protected $casts = [
        'ipk'           => 'decimal:2',
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public function sk()
    {
        return $this->belongsTo(YudisiumSk::class, 'yudisium_sk_id');
    }

    public function sidang()
    {
        return $this->belongsTo(Sidang::class);
    }

    /** Mis. "Aceh Besar, 19 Mei 2004". */
    public function tempatTanggalLahir(): string
    {
        return trim($this->tempat_lahir) . ', ' . PengajuanSk::tanggalIndonesia($this->tanggal_lahir);
    }
}