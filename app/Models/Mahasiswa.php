<?php
// FIX: file ini menggantikan app/Models/Mahasiswa.php
// Perubahan: tambah relasi proposal() dan sidang() supaya bisa dicek status
// pendaftaran mahasiswa (dipakai MahasiswaController::dashboard()).

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PengajuanSk;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
    'user_id',
    'prodi_id',
    'nim',
    'nama',
    'angkatan',
    'pembimbing1_id',
    'pembimbing2_id',
    'pembimbing_lkp_id', // FIX: sebelumnya tidak ada di $fillable padahal dipakai di MahasiswaController::pilihDosenLkp() -> mass assignment akan diabaikan diam-diam kalau dipakai via create()/fill(); di sini masih aman karena kode aslinya set properti langsung + save(), tapi lebih konsisten kalau ikut didaftarkan.
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class);
    }

    public function pengajuanPembimbing()
    {
        return $this->hasMany(PengajuanPembimbing::class);
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1_id');
    }

    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2_id');
    }

    public function seminarLkp()
    {
        return $this->hasOne(SeminarLkp::class);
    }

    public function pembimbingLkp()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_lkp_id');
    }

    // BARU
    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }

    // BARU
    public function sidang()
    {
        return $this->hasOne(Sidang::class);
    }

    public function pengajuanSk()
    {
        return $this->hasOne(PengajuanSk::class);
    }

    // BARU
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Syarat SK Pembimbing & SK Pembahas
    | Kaprodi baru dapat meneruskan ke dekan setelah KEDUA dosen pembahas
    | menginput seluruh nilai Seminar Proposal. Aturan ini hanya ada di sini,
    | jadi mudah diubah bila kebijakan berubah.
    |--------------------------------------------------------------------------
    */

    /** Kelengkapan nilai seminar proposal: ['lengkap', 'masuk', 'total']. */
    public function statusNilaiProposal(): array
    {
        $akhir = $this->proposal ? $this->proposal->nilaiAkhir() : null;

        return [
            'lengkap' => (bool) ($akhir['lengkap'] ?? false),
            'masuk'   => $akhir['jumlah_masuk'] ?? 0,
            'total'   => $akhir['jumlah_penguji'] ?? 2,
        ];
    }

    /** Alasan SK belum bisa diteruskan kaprodi ke dekan (kosong = siap diteruskan). */
    public function kekuranganSkDekan(): array
    {
        $kurang = [];

        if (!$this->proposal) {
            return ['belum mendaftar seminar proposal'];
        }

        if (!$this->proposal->penguji1_id || !$this->proposal->penguji2_id) {
            $kurang[] = 'pembahas proposal belum ditetapkan';
        } else {
            $n = $this->statusNilaiProposal();
            if (!$n['lengkap']) {
                $kurang[] = 'nilai Seminar Proposal belum lengkap (' . $n['masuk'] . ' dari ' . $n['total'] . ' pembahas)';
            }
        }

        if (!$this->pembimbing1_id || !$this->pembimbing2_id) {
            $kurang[] = 'dosen pembimbing belum lengkap';
        }
        if (blank($this->proposal->judul)) {
            $kurang[] = 'judul proposal kosong';
        }

        return $kurang;
    }

    /** SK Pembimbing & Pembahas mahasiswa ini sudah diteruskan kaprodi ke dekan. */
    public function sudahDiteruskanKeDekan(): bool
    {
        return (bool) optional($this->pengajuanSk)->kaprodi_approved;
    }
}