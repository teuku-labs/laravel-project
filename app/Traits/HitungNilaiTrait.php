<?php

namespace App\Traits;

trait HitungNilaiTrait
{
    /**
     * Hitung rata-rata dari 4 aspek penilaian (bobot sama, masing-masing 25%).
     */
    public static function hitungRataRata($isiMateri, $penyajian, $penguasaanMateri, $sikapMental): float
    {
        return round((floatval($isiMateri) + floatval($penyajian) + floatval($penguasaanMateri) + floatval($sikapMental)) / 4, 2);
    }

    /**
     * Konversi nilai (skala 0-100) menjadi nilai huruf, sesuai pedoman kaprodi:
     * A 85-100, A- 80-84, B+ 75-79, B 70-74, B- 65-69,
     * C+ 60-64, C 55-59, D 40-54, E < 40.
     *
     * Memakai batas bawah (>=) supaya nilai desimal seperti 84,5 tidak jatuh
     * ke celah antar rentang.
     */
    public static function hitungNilaiHuruf(float $rataRata): string
    {
        return match (true) {
            $rataRata >= 85 => 'A',
            $rataRata >= 80 => 'A-',
            $rataRata >= 75 => 'B+',
            $rataRata >= 70 => 'B',
            $rataRata >= 65 => 'B-',
            $rataRata >= 60 => 'C+',
            $rataRata >= 55 => 'C',
            $rataRata >= 40 => 'D',
            default         => 'E',
        };
    }

    /**
     * Nilai minimal agar seminar (LKP, proposal, sidang) dinyatakan lulus
     * dan mahasiswa boleh mendaftar ke tahap berikutnya: minimal C (55).
     * Cukup ubah angka di sini, semua pengecekan lulus ikut berubah.
     */
    public static function batasLulus(): float
    {
        return 55.0;
    }
}