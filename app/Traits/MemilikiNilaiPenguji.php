<?php

namespace App\Traits;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;

/**
 * Dipakai Proposal dan Sidang, yang masing-masing punya dua dosen penguji.
 * Tiap penguji menyimpan nilainya sendiri (satu baris per penguji), sehingga
 * tidak saling menimpa. Nilai akhir = rata-rata nilai semua penguji.
 *
 * Model pemakai wajib punya relasi nilaiPenguji() (hasMany) dan kolom
 * penguji1_id / penguji2_id.
 */
trait MemilikiNilaiPenguji
{
    use HitungNilaiTrait;

    /** Baris nilai milik dosen tertentu (null jika belum menilai). */
    public function nilaiOleh(?Dosen $dosen): ?Model
    {
        if (!$dosen) {
            return null;
        }

        return $this->nilaiPenguji->firstWhere('dosen_id', $dosen->id);
    }

    /** Baris nilai milik penguji ke-1 atau ke-2. */
    public function nilaiPengujiKe(int $ke): ?Model
    {
        $dosenId = $this->{'penguji' . $ke . '_id'};

        return $dosenId ? $this->nilaiPenguji->firstWhere('dosen_id', $dosenId) : null;
    }

    /**
     * Nilai akhir gabungan semua penguji yang sudah menilai.
     * Dihitung dari nilai mentah keempat aspek, dibulatkan sekali di akhir.
     * 'lengkap' bernilai true hanya jika SEMUA penguji sudah menilai.
     * Mengembalikan null jika belum ada penguji yang menilai.
     */
    public function nilaiAkhir(): ?array
    {
        $idPenguji = array_values(array_unique(array_filter([
            $this->penguji1_id,
            $this->penguji2_id,
        ])));

        if (empty($idPenguji)) {
            return null;
        }

        $masuk = $this->nilaiPenguji->whereIn('dosen_id', $idPenguji);

        if ($masuk->isEmpty()) {
            return null;
        }

        $rata = round($masuk->avg(fn ($n) => (
            (float) $n->isi_materi + (float) $n->penyajian
            + (float) $n->penguasaan_materi + (float) $n->sikap_mental
        ) / 4), 2);

        return [
            'rata_rata'      => $rata,
            'nilai_huruf'    => static::hitungNilaiHuruf($rata),
            'jumlah_masuk'   => $masuk->count(),
            'jumlah_penguji' => count($idPenguji),
            'lengkap'        => $masuk->count() === count($idPenguji),
        ];
    }

    /**
     * Lulus jika semua penguji sudah menilai dan nilai akhir mencapai batas lulus.
     */
    public function lulus(): bool
    {
        $akhir = $this->nilaiAkhir();

        return $akhir !== null
            && $akhir['lengkap']
            && $akhir['rata_rata'] >= static::batasLulus();
    }
}