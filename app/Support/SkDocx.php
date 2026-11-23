<?php

namespace App\Support;

use RuntimeException;
use ZipArchive;

/**
 * Mengisi template Word (.docx) yang berisi penanda {{nama}} tanpa package tambahan.
 * Memakai ekstensi ZipArchive bawaan PHP (aktif di Laragon).
 *
 * Selain penanda biasa, template boleh punya satu baris tabel "contoh" yang memuat
 * penanda dari baris data (mis. {{no}}, {{nim}}). Baris itu digandakan satu kali per
 * elemen $rows, lalu baris contohnya dibuang.
 */
class SkDocx
{
    /**
     * @param  string                          $template  path template .docx
     * @param  array<string,string>            $values    ['nomor_sk' => '...', ...]
     * @param  array<int,array<string,string>> $rows      data baris tabel (kunci = nama penanda di baris contoh)
     * @return string                                     path file .docx sementara hasil pengisian
     */
    public static function render(string $template, array $values, array $rows = []): string
    {
        if (!is_file($template)) {
            throw new RuntimeException('Template SK tidak ditemukan: ' . $template);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'sk_');
        copy($template, $tmp);

        $zip = new ZipArchive();
        if ($zip->open($tmp) !== true) {
            throw new RuntimeException('Template SK tidak bisa dibuka.');
        }

        $xml = $zip->getFromName('word/document.xml');
        if ($xml === false) {
            $zip->close();
            throw new RuntimeException('Template SK tidak valid (document.xml tidak ada).');
        }

        $xml = self::isiBaris($xml, $rows);
        $xml = self::ganti($xml, $values);

        $zip->addFromString('word/document.xml', $xml);
        $zip->close();

        return $tmp;
    }

    /** @param array<string,string> $values */
    private static function ganti(string $xml, array $values): string
    {
        foreach ($values as $key => $value) {
            $xml = str_replace(
                '{{' . $key . '}}',
                htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8'),
                $xml
            );
        }

        return $xml;
    }

    /**
     * Menggandakan baris tabel contoh. Baris contoh dikenali dari penanda pertama di $rows[0];
     * bila $rows kosong, baris contoh dibuang supaya penanda tidak tercetak di dokumen.
     *
     * @param array<int,array<string,string>> $rows
     */
    private static function isiBaris(string $xml, array $rows): string
    {
        // Tanpa data, cari baris contoh lewat penanda "no" (kunci standar lampiran).
        $kunci = $rows ? array_key_first($rows[0]) : 'no';
        $tanda = '{{' . $kunci . '}}';

        $pos = strpos($xml, $tanda);
        if ($pos === false) {
            return $xml; // template tidak punya baris contoh
        }

        $awal = max(
            (int) strrpos(substr($xml, 0, $pos), '<w:tr>'),
            (int) strrpos(substr($xml, 0, $pos), '<w:tr ')
        );
        $akhirTag = strpos($xml, '</w:tr>', $pos);
        if ($akhirTag === false) {
            throw new RuntimeException('Template SK tidak valid (baris tabel tidak lengkap).');
        }
        $akhir = $akhirTag + strlen('</w:tr>');

        $contoh = substr($xml, $awal, $akhir - $awal);

        $hasil = '';
        foreach ($rows as $row) {
            $hasil .= self::ganti($contoh, $row);
        }

        return substr($xml, 0, $awal) . $hasil . substr($xml, $akhir);
    }
}