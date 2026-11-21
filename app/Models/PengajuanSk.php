<?php

namespace App\Models;

use App\Support\SkDocx;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PengajuanSk extends Model
{
    protected $table = 'pengajuan_sks';

    protected $fillable = [
        'mahasiswa_id',
        'pembimbing1_id',
        'pembimbing2_id',
        'nomor_sk',
        'tanggal_sk',
        'admin_verified',
        'kaprodi_approved',
        'kaprodi_rejected',
        'catatan_kaprodi'
    ];

    protected $casts = [
        'tanggal_sk' => 'date:Y-m-d',
    ];

    private const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
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

    /** SK dianggap terbit setelah dekan mengisi nomor dan tanggal SK. */
    public function sudahTerbit(): bool
    {
        return filled($this->nomor_sk) && $this->tanggal_sk !== null;
    }

    /** Format tanggal Indonesia tanpa bergantung pada locale server, mis. "2 Oktober 2025". */
    public static function tanggalIndonesia($tanggal): string
    {
        $d = Carbon::parse($tanggal);

        return $d->day . ' ' . self::BULAN[$d->month] . ' ' . $d->year;
    }

    /**
     * TA Semester dihitung dari tanggal SK (atau tanggal pengajuan bila SK belum terbit):
     *  - September-Desember : Ganjil  tahun/tahun+1
     *  - Januari-Februari   : Ganjil  tahun-1/tahun
     *  - Maret-Agustus      : Genap   tahun-1/tahun
     */
    public function taSemester(): string
    {
        $d = Carbon::parse($this->tanggal_sk ?? $this->created_at ?? now());

        if ($d->month >= 9) {
            return 'Ganjil ' . $d->year . '/' . ($d->year + 1);
        }
        if ($d->month <= 2) {
            return 'Ganjil ' . ($d->year - 1) . '/' . $d->year;
        }

        return 'Genap ' . ($d->year - 1) . '/' . $d->year;
    }

    /** Judul TGA diambil dari judul proposal mahasiswa. */
    public function judulTga(): ?string
    {
        $judul = optional(optional($this->mahasiswa)->proposal)->judul;

        return filled($judul) ? trim($judul) : null;
    }

    /** Tempat/tanggal lahir diambil dari data pendaftaran LKP, mis. "Bireuen, 15 Desember 2000". */
    public function tempatTanggalLahir(): ?string
    {
        $lkp = optional($this->mahasiswa)->seminarLkp;

        if (!$lkp || blank($lkp->tempat_lahir) || blank($lkp->tanggal_lahir)) {
            return null;
        }

        return trim($lkp->tempat_lahir) . ', ' . self::tanggalIndonesia($lkp->tanggal_lahir);
    }

    /** Daftar data yang masih kurang sehingga SK belum bisa dicetak/diunduh (kosong = lengkap). */
    public function kekuranganData(): array
    {
        $this->loadMissing(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'mahasiswa.proposal', 'pembimbing1', 'pembimbing2']);

        $kurang = [];
        if (!$this->judulTga())          $kurang[] = 'judul (mahasiswa belum mendaftar proposal)';
        if (!$this->tempatTanggalLahir()) $kurang[] = 'tempat/tanggal lahir (mahasiswa belum mendaftar LKP)';
        if (!$this->pembimbing1)         $kurang[] = 'pembimbing utama';
        if (!$this->pembimbing2)         $kurang[] = 'pembimbing pendamping';

        return $kurang;
    }

    public function namaFileSk(): string
    {
        return 'SK-Pembimbing-' . (optional($this->mahasiswa)->nim ?? $this->id) . '.docx';
    }

    /** Membuat file Word SK dari template. Mengembalikan path file sementara. */
    public function buatFileSk(): string
    {
        $this->loadMissing(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'mahasiswa.proposal', 'pembimbing1', 'pembimbing2']);

        $mhs = $this->mahasiswa;

        return SkDocx::render(resource_path('templates/sk-pembimbing.docx'), [
            'nomor_sk'    => $this->nomor_sk,
            'pembimbing1' => $this->pembimbing1->nama,
            'pembimbing2' => $this->pembimbing2->nama,
            'nama'        => $mhs->nama,
            'ttl'         => $this->tempatTanggalLahir(),
            'nim'         => $mhs->nim,
            'prodi'       => optional($mhs->prodi)->nama_prodi ?? '-',
            'judul'       => mb_strtoupper(rtrim(trim($this->judulTga()), ". \t")),
            'tanggal_sk'  => self::tanggalIndonesia($this->tanggal_sk),
        ]);
    }
}