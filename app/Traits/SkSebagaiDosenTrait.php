<?php

namespace App\Traits;

use App\Models\Dosen;
use App\Models\PengajuanSk;
use App\Models\Proposal;

/**
 * Download SK untuk akun yang berperan ganda (Kaprodi / Dekan sekaligus Dosen).
 *
 * Aturannya sama persis dengan DosenController::skItemsUntuk() & skPembimbing/PembahasUnduh():
 * SK hanya tampil/bisa diunduh bila akun ini tercantum sebagai pembimbing 1/2 atau
 * pembahas 1/2, SK sudah diteruskan kaprodi, dan SK sudah diterbitkan dekan.
 * Perbedaannya hanya nama route (tiap peran punya halamannya sendiri), jadi nama
 * route dan route tujuan "kembali" dikirim sebagai parameter.
 */
trait SkSebagaiDosenTrait
{
    /**
     * @param string $rutePembimbing nama route unduh SK Pembimbing (menerima {id})
     * @param string $rutePembahas   nama route unduh SK Pembahas (menerima {id})
     */
    protected function skItemsUntukDosen(Dosen $dosen, string $rutePembimbing, string $rutePembahas)
    {
        $skPembimbing = PengajuanSk::with('mahasiswa')
            ->where('kaprodi_approved', true)
            ->where(fn ($q) => $q->where('pembimbing1_id', $dosen->id)->orWhere('pembimbing2_id', $dosen->id))
            ->get()
            ->filter(fn ($p) => $p->sudahTerbit())
            ->map(fn ($p) => (object) [
                'jenis'     => 'SK Pembimbing',
                'mahasiswa' => optional($p->mahasiswa)->nama ?? '-',
                'nim'       => optional($p->mahasiswa)->nim ?? '-',
                'peran'     => $p->pembimbing1_id == $dosen->id ? 'Pembimbing Utama' : 'Pembimbing Pendamping',
                'nomor_sk'  => $p->nomor_sk,
                'tanggal'   => $p->tanggal_sk,
                'url'       => route($rutePembimbing, $p->id),
            ]);

        $skPembahas = Proposal::with('mahasiswa')
            ->whereNotNull('sk_pembahas_diteruskan_at')
            ->where(fn ($q) => $q->where('penguji1_id', $dosen->id)->orWhere('penguji2_id', $dosen->id))
            ->get()
            ->filter(fn ($p) => $p->sudahTerbitSkPembahas())
            ->map(fn ($p) => (object) [
                'jenis'     => 'SK Pembahas',
                'mahasiswa' => optional($p->mahasiswa)->nama ?? '-',
                'nim'       => optional($p->mahasiswa)->nim ?? '-',
                'peran'     => $p->penguji1_id == $dosen->id ? 'Pembahas I' : 'Pembahas II',
                'nomor_sk'  => $p->nomor_sk_pembahas,
                'tanggal'   => $p->tanggal_sk_pembahas,
                'url'       => route($rutePembahas, $p->id),
            ]);

        return $skPembimbing->concat($skPembahas)
            ->sortByDesc(fn ($x) => $x->tanggal)->values();
    }

    /** Unduh SK Pembimbing milik akun ini. Mengembalikan response unduhan atau redirect berisi pesan error. */
    protected function unduhSkPembimbingSaya(?Dosen $dosen, $id, string $ruteKembali)
    {
        if (!$dosen) {
            return redirect()->route($ruteKembali)->with('error', 'Akun Anda belum terhubung dengan data dosen.');
        }

        $sk = PengajuanSk::where('kaprodi_approved', true)
            ->where(fn ($q) => $q->where('pembimbing1_id', $dosen->id)->orWhere('pembimbing2_id', $dosen->id))
            ->findOrFail($id);

        if (!$sk->sudahTerbit()) {
            return redirect()->route($ruteKembali)->with('error', 'SK belum diterbitkan oleh dekan.');
        }

        $kurang = $sk->kekuranganData();
        if ($kurang) {
            return redirect()->route($ruteKembali)->with('error', 'SK belum bisa diunduh, data belum lengkap: ' . implode(', ', $kurang) . '.');
        }

        try {
            $file = $sk->buatFileSk();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route($ruteKembali)->with('error', 'Gagal membuat file SK, silakan coba lagi.');
        }

        return response()->download($file, $sk->namaFileSk(), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    /** Unduh SK Pembahas milik akun ini. */
    protected function unduhSkPembahasSaya(?Dosen $dosen, $id, string $ruteKembali)
    {
        if (!$dosen) {
            return redirect()->route($ruteKembali)->with('error', 'Akun Anda belum terhubung dengan data dosen.');
        }

        $proposal = Proposal::whereNotNull('sk_pembahas_diteruskan_at')
            ->where(fn ($q) => $q->where('penguji1_id', $dosen->id)->orWhere('penguji2_id', $dosen->id))
            ->findOrFail($id);

        if (!$proposal->sudahTerbitSkPembahas()) {
            return redirect()->route($ruteKembali)->with('error', 'SK belum diterbitkan oleh dekan.');
        }

        $kurang = $proposal->kekuranganDataSkPembahas();
        if ($kurang) {
            return redirect()->route($ruteKembali)->with('error', 'SK belum bisa diunduh, data belum lengkap: ' . implode(', ', $kurang) . '.');
        }

        try {
            $file = $proposal->buatFileSkPembahas();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route($ruteKembali)->with('error', 'Gagal membuat file SK, silakan coba lagi.');
        }

        return response()->download($file, $proposal->namaFileSkPembahas(), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}