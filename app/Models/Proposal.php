<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MemilikiNilaiPenguji;
use App\Support\SkDocx;

class Proposal extends Model
{
    use MemilikiNilaiPenguji;

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
        'nomor_sk_pembahas',
        'tanggal_sk_pembahas',
        'sk_pembahas_diteruskan_at',
    ];

    protected $casts = [
        'admin_verified' => 'boolean',
        'tanggal_sk_pembahas' => 'date',
        'sk_pembahas_diteruskan_at' => 'datetime',
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

    /** Satu baris nilai per dosen penguji. */
    public function nilaiPenguji()
    {
        return $this->hasMany(NilaiProposal::class, 'proposal_id');
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

    /*
    |--------------------------------------------------------------------------
    | SK Pembahas (dekan mengisi nomor + tanggal SK setelah kaprodi
    | menetapkan dua dosen pembahas, lalu SK dicetak dari template Word)
    |--------------------------------------------------------------------------
    */

    public function sudahTerbitSkPembahas(): bool
    {
        return filled($this->nomor_sk_pembahas) && !empty($this->tanggal_sk_pembahas);
    }

    /** TA Semester dari tanggal SK (atau tanggal pendaftaran proposal bila SK belum terbit). */
    public function taSemester(): string
    {
        return PengajuanSk::hitungTaSemester($this->tanggal_sk_pembahas ?? $this->created_at ?? now());
    }

    /** Tempat/tanggal lahir dari data pendaftaran LKP, mis. "Bireuen, 15 Desember 2000". */
    public function tempatTanggalLahir(): ?string
    {
        return PengajuanSk::formatTtlDariLkp(optional($this->mahasiswa)->seminarLkp);
    }

    /** Daftar data yang masih kurang sehingga SK belum bisa dicetak/diunduh (kosong = lengkap). */
    public function kekuranganDataSkPembahas(): array
    {
        $this->loadMissing(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'penguji1', 'penguji2']);

        $kurang = [];
        if (blank($this->judul))          $kurang[] = 'judul proposal';
        if (!$this->tempatTanggalLahir()) $kurang[] = 'tempat/tanggal lahir (mahasiswa belum mendaftar LKP)';
        if (!$this->penguji1)             $kurang[] = 'pembahas 1';
        if (!$this->penguji2)             $kurang[] = 'pembahas 2';

        return $kurang;
    }

    public function namaFileSkPembahas(): string
    {
        return 'SK-Pembahas-' . (optional($this->mahasiswa)->nim ?? $this->id) . '.docx';
    }

    /** Membuat file Word SK Pembahas dari template. Mengembalikan path file sementara. */
    public function buatFileSkPembahas(): string
    {
        $this->loadMissing(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'penguji1', 'penguji2']);

        $mhs = $this->mahasiswa;

        return SkDocx::render(resource_path('templates/sk-pembahas.docx'), [
            'nomor_sk'   => $this->nomor_sk_pembahas,
            'pembahas1'  => $this->penguji1->nama,
            'pembahas2'  => $this->penguji2->nama,
            'nama'       => $mhs->nama,
            'ttl'        => $this->tempatTanggalLahir(),
            'nim'        => $mhs->nim,
            'prodi'      => optional($mhs->prodi)->nama_prodi ?? '-',
            'judul'      => mb_strtoupper(rtrim(trim($this->judul), ". \t")),
            'tanggal_sk' => PengajuanSk::tanggalIndonesia($this->tanggal_sk_pembahas),
        ]);
    }
}