<?php

namespace App\Traits;

trait HitungNilaiTrait
{
    /**
     * Hitung rata-rata dari 4 aspek penilaian.
     */
    public static function hitungRataRata($isiMateri, $penyajian, $penguasaanMateri, $sikapMental): float
    {
        return round((floatval($isiMateri) + floatval($penyajian) + floatval($penguasaanMateri) + floatval($sikapMental)) / 4, 2);
    }

    /**
     * Konversi rata-rata (skala 0-100) menjadi nilai huruf.
     * Ambang batas mengikuti konversi umum akademik:
     * A >= 80, B >= 70, C >= 60, D >= 50, E < 50
     */
    public static function hitungNilaiHuruf(float $rataRata): string
    {
        return match (true) {
            $rataRata >= 80 => 'A',
            $rataRata >= 70 => 'B',
            $rataRata >= 60 => 'C',
            $rataRata >= 50 => 'D',
            default         => 'E',
        };
    }
}