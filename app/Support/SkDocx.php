<?php

namespace App\Support;

use RuntimeException;
use ZipArchive;

/**
 * Mengisi template Word (.docx) yang berisi penanda {{nama}} tanpa package tambahan.
 * Memakai ekstensi ZipArchive bawaan PHP (aktif di Laragon).
 */
class SkDocx
{
    /**
     * @param  string               $template  path template .docx
     * @param  array<string,string> $values    ['nomor_sk' => '...', ...]
     * @return string                          path file .docx sementara hasil pengisian
     */
    public static function render(string $template, array $values): string
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

        foreach ($values as $key => $value) {
            $xml = str_replace(
                '{{' . $key . '}}',
                htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8'),
                $xml
            );
        }

        $zip->addFromString('word/document.xml', $xml);
        $zip->close();

        return $tmp;
    }
}