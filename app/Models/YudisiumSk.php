<?php

namespace App\Models;

use App\Support\SkDocx;
use Illuminate\Database\Eloquent\Model;

/**
 * SK Yudisium kolektif, satu SK per prodi per pengajuan (gelombang).
 * Kaprodi mengajukan -> status 'diajukan'; dekan mengisi nomor + tanggal -> 'terbit'.
 */
class YudisiumSk extends Model
{
    public const DIAJUKAN = 'diajukan';
    public const TERBIT   = 'terbit';

    /** Kode Perguruan Tinggi Universitas Abulyatama pada lampiran SK. */
    public const KODE_PT = '131003';

    protected $table = 'yudisium_sks';

    protected $fillable = ['prodi_id', 'nomor_sk', 'tanggal_sk', 'status', 'diajukan_at'];

    protected $casts = [
        'tanggal_sk'  => 'date:Y-m-d',
        'diajukan_at' => 'datetime',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function sidangs()
    {
        return $this->hasMany(Sidang::class, 'yudisium_sk_id');
    }

    public function anggota()
    {
        return $this->hasMany(YudisiumSkMahasiswa::class, 'yudisium_sk_id');
    }

    public function sudahTerbit(): bool
    {
        return $this->status === self::TERBIT && filled($this->nomor_sk) && $this->tanggal_sk !== null;
    }

    /** Semester dan tahun akademik dari tanggal SK, mis. ['GENAP', '2025-2026']. */
    public function semesterAkademik(): array
    {
        [$jenis, $tahun] = explode(' ', PengajuanSk::hitungTaSemester($this->tanggal_sk), 2);

        return [strtoupper($jenis), str_replace('/', '-', $tahun)];
    }

    /** Label singkat, mis. "Genap 2025/2026". */
    public function labelSemester(): string
    {
        return PengajuanSk::hitungTaSemester($this->tanggal_sk ?? $this->diajukan_at ?? now());
    }

    /** Kode tahun-semester seperti di lampiran, mis. 20252 (tahun akademik 2025, semester genap). */
    public function kodeTahunLulus(): string
    {
        [$jenis, $tahun] = explode(' ', PengajuanSk::hitungTaSemester($this->tanggal_sk), 2);

        return substr($tahun, 0, 4) . ($jenis === 'Genap' ? '2' : '1');
    }

    public function namaFileSk(): string
    {
        // Nomor SK memuat '/' dan '.', jadi diganti '-' agar aman dipakai sebagai nama file.
        $nomor = trim(preg_replace('/[^A-Za-z0-9]+/', '-', (string) $this->nomor_sk), '-');
        $prodi = $this->prodi ? '-' . trim(preg_replace('/[^A-Za-z0-9]+/', '-', $this->prodi->nama_prodi), '-') : '';

        return 'SK-Yudisium' . $prodi . '-' . $nomor . '.docx';
    }

    /** Baris lampiran (urut nama) untuk tabel di template Word. */
    public function barisLampiran(): array
    {
        $tanggalSk = PengajuanSk::tanggalIndonesia($this->tanggal_sk);
        $tahunLulus = $this->kodeTahunLulus();

        $anggota = $this->anggota()->with(['sidang.mahasiswa.prodi'])->get()
            ->sortBy(fn ($a) => mb_strtolower(optional(optional($a->sidang)->mahasiswa)->nama ?? ''))
            ->values();

        return $anggota->map(function ($a, $i) use ($tanggalSk, $tahunLulus) {
            $mhs   = optional($a->sidang)->mahasiswa;
            $prodi = optional($mhs)->prodi;

            return [
                'no'               => (string) ($i + 1),
                'kode_pt'          => self::KODE_PT,
                'kode_prodi'       => (string) ($prodi->kode_prodi ?? ''),
                'nim'              => (string) ($mhs->nim ?? ''),
                'tahun_masuk'      => ($mhs->angkatan ?? '') . '1',
                'tahun_lulus'      => $tahunLulus,
                'tanggal_lulus'    => $a->sidang && $a->sidang->tanggal_sidang
                                        ? \Carbon\Carbon::parse($a->sidang->tanggal_sidang)->format('d/m/y') : '',
                'nama'             => (string) ($mhs->nama ?? ''),
                'ttl'              => $a->tempatTanggalLahir(),
                'nama_prodi'       => (string) ($prodi->nama_prodi ?? ''),
                'ipk'              => number_format((float) $a->ipk, 2, '.', ''),
                'tanggal_yudisium' => $tanggalSk,
            ];
        })->all();
    }

    /** Membuat file Word SK Yudisium (isi surat + lampiran nama). Mengembalikan path file sementara. */
    public function buatFileSk(): string
    {
        if (!$this->sudahTerbit()) {
            throw new \RuntimeException('SK Yudisium belum terbit (nomor dan tanggal SK belum diisi dekan).');
        }

        [$semester, $tahunAkademik] = $this->semesterAkademik();
        $namaProdi = (string) optional($this->prodi)->nama_prodi;

        return SkDocx::render(resource_path('templates/sk-yudisium.docx'), [
            'nomor_sk'        => $this->nomor_sk,
            'tanggal_sk'      => PengajuanSk::tanggalIndonesia($this->tanggal_sk),
            'semester'        => $semester,
            'tahun_akademik'  => $tahunAkademik,
            'nama_prodi'      => $namaProdi,
            'nama_prodi_caps' => mb_strtoupper($namaProdi),
        ], $this->barisLampiran());
    }
}