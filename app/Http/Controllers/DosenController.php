<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Sk;
use App\Models\PengajuanSk;
use App\Models\PengajuanPembimbing;
use App\Models\SeminarLkp;
use App\Models\Proposal;
use App\Models\Sidang;
use App\Models\NilaiSeminarLkp;
use App\Models\NilaiProposal;
use App\Models\NilaiSidang;

class DosenController extends Controller
{
    private function getDosen()
    {
        return Dosen::where('user_id', Auth::id())->first();
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data dosen belum terhubung dengan akun user.']);
        }

        $mahasiswaCount = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)->count();

        $jadwals        = Jadwal::where('dosen_id', $dosen->id)->get();
        $upcomingJadwal = $jadwals->where('tanggal', '>=', now())->count();

        // SK yang sudah terbit dan memuat dosen ini (Pembimbing + Pembahas)
        $skItems        = $this->skItemsUntuk($dosen);
        $skCount        = $skItems->count();

        // ✅ Pengajuan bimbingan yang belum direspons
        $pengajuanBaru  = PengajuanPembimbing::where('dosen_id', $dosen->id)
                            ->where('status', 'pending')
                            ->with('mahasiswa.prodi')
                            ->get();

        return view('dosen.dashboard', compact(
            'dosen', 'mahasiswaCount', 'jadwals',
            'upcomingJadwal', 'skItems', 'skCount',
            'pengajuanBaru'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE PENGAJUAN BIMBINGAN
    |--------------------------------------------------------------------------
    */
    public function approveBimbingan($id)
    {
        $dosen     = $this->getDosen();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $dosen->id)
                        ->firstOrFail();

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $jenis     = $pengajuan->catatan; // 'pembimbing1' atau 'pembimbing2'

        // Validasi: cek apakah slot pembimbing masih kosong
        if ($jenis === 'pembimbing1' && $mahasiswa->pembimbing1_id) {
            return back()->with('error', 'Mahasiswa ini sudah punya Pembimbing 1.');
        }
        if ($jenis === 'pembimbing2' && $mahasiswa->pembimbing2_id) {
            return back()->with('error', 'Mahasiswa ini sudah punya Pembimbing 2.');
        }

        // Set pembimbing di tabel mahasiswa
        if ($jenis === 'pembimbing1') {
            $mahasiswa->pembimbing1_id = $dosen->id;
        } elseif ($jenis === 'pembimbing2') {
            $mahasiswa->pembimbing2_id = $dosen->id;
        }
        $mahasiswa->save();

        // Update status pengajuan
        $pengajuan->update(['status' => 'approved']);

        // Tolak pengajuan lain dari mahasiswa yang sama untuk slot yang sama
        PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', '!=', $id)
            ->where('catatan', $jenis)
            ->where('status', 'pending')
            ->update(['status' => 'rejected', 'catatan' => $jenis . '|auto-rejected']);

        return back()->with('success',
            'Anda berhasil menyetujui permintaan bimbingan dari ' . $mahasiswa->nama . '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT PENGAJUAN BIMBINGAN
    |--------------------------------------------------------------------------
    */
    public function rejectBimbingan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:255',
        ]);

        $dosen     = $this->getDosen();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $dosen->id)
                        ->firstOrFail();

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $jenis     = $pengajuan->catatan;
        $alasan    = $request->alasan ?: 'Tidak ada alasan';

        $pengajuan->update([
            'status'  => 'rejected',
            'catatan' => $jenis . '|' . $alasan,
        ]);

        return back()->with('success',
            'Permintaan bimbingan dari ' . $mahasiswa->nama . ' telah ditolak.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NILAI SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function nilaiLkpIndex()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        // Pembimbing & penguji sama-sama bisa MELIHAT, tapi hanya penguji
        // yang boleh mengisi/mengedit nilai (dibatasi di nilaiLkpStore()
        // dan di view lewat status read-only).
        $seminarList = SeminarLkp::where('pembimbing1_id', $dosen->id)
            ->orWhere('penguji_id', $dosen->id)
            ->with(['mahasiswa', 'dosen', 'penguji', 'nilai'])
            ->latest()->get();

        return view('dosen.nilai-lkp', compact('dosen', 'seminarList'));
    }

    public function nilaiLkpStore(Request $request, $id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        // Hanya dosen yang ditunjuk sebagai penguji yang boleh mengisi nilai.
        $seminar = SeminarLkp::where('penguji_id', $dosen->id)
            ->findOrFail($id);

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiSeminarLkp::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiSeminarLkp::hitungNilaiHuruf($rataRata);

        NilaiSeminarLkp::updateOrCreate(
            ['seminar_lkp_id' => $seminar->id],
            [
                'isi_materi'        => $request->isi_materi,
                'penyajian'         => $request->penyajian,
                'penguasaan_materi' => $request->penguasaan_materi,
                'sikap_mental'      => $request->sikap_mental,
                'rata_rata'         => $rataRata,
                'nilai_huruf'       => $nilaiHuruf,
                'dinilai_oleh'      => $dosen->nama,
                'dinilai_oleh_role' => 'Dosen',
            ]
        );

        return back()->with('success', 'Nilai seminar LKP berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | NILAI SEMINAR PROPOSAL
    |--------------------------------------------------------------------------
    */
    public function nilaiProposalIndex()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        // Hanya proposal yang dosen ini uji (pembahas/penguji 1 atau 2)
        $proposalList = Proposal::where(function ($q) use ($dosen) {
                $q->where('penguji1_id', $dosen->id)
                  ->orWhere('penguji2_id', $dosen->id);
            })
            ->with(['mahasiswa', 'pembimbing1', 'penguji1', 'penguji2', 'nilaiPenguji'])
            ->latest()->get();

        return view('dosen.proposal', compact('dosen', 'proposalList'));
    }

    public function nilaiProposalStore(Request $request, $id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $proposal = Proposal::where(function ($q) use ($dosen) {
                $q->where('penguji1_id', $dosen->id)
                  ->orWhere('penguji2_id', $dosen->id);
            })->findOrFail($id);

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiProposal::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiProposal::hitungNilaiHuruf($rataRata);

        NilaiProposal::updateOrCreate(
            ['proposal_id' => $proposal->id, 'dosen_id' => $dosen->id],
            [
                'isi_materi'        => $request->isi_materi,
                'penyajian'         => $request->penyajian,
                'penguasaan_materi' => $request->penguasaan_materi,
                'sikap_mental'      => $request->sikap_mental,
                'rata_rata'         => $rataRata,
                'nilai_huruf'       => $nilaiHuruf,
                'dinilai_oleh'      => $dosen->nama,
                'dinilai_oleh_role' => 'Dosen',
            ]
        );

        return back()->with('success', 'Nilai seminar proposal berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | NILAI SIDANG SKRIPSI
    |--------------------------------------------------------------------------
    */
    public function nilaiSidangIndex()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        // Hanya sidang yang dosen ini uji (pembahas/penguji 1 atau 2)
        $sidangList = Sidang::where(function ($q) use ($dosen) {
                $q->where('penguji1_id', $dosen->id)
                  ->orWhere('penguji2_id', $dosen->id);
            })
            ->with(['mahasiswa', 'pembimbing', 'penguji1', 'penguji2', 'nilaiPenguji'])
            ->latest()->get();

        return view('dosen.sidang', compact('dosen', 'sidangList'));
    }

    public function nilaiSidangStore(Request $request, $id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $sidang = Sidang::where(function ($q) use ($dosen) {
                $q->where('penguji1_id', $dosen->id)
                  ->orWhere('penguji2_id', $dosen->id);
            })->findOrFail($id);

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiSidang::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiSidang::hitungNilaiHuruf($rataRata);

        NilaiSidang::updateOrCreate(
            ['sidang_id' => $sidang->id, 'dosen_id' => $dosen->id],
            [
                'isi_materi'        => $request->isi_materi,
                'penyajian'         => $request->penyajian,
                'penguasaan_materi' => $request->penguasaan_materi,
                'sikap_mental'      => $request->sikap_mental,
                'rata_rata'         => $rataRata,
                'nilai_huruf'       => $nilaiHuruf,
                'dinilai_oleh'      => $dosen->nama,
                'dinilai_oleh_role' => 'Dosen',
            ]
        );

        return back()->with('success', 'Nilai sidang skripsi berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $jadwals = Jadwal::where('dosen_id', $dosen->id)
                    ->orderBy('tanggal', 'asc')->get();

        $upcomingJadwal = $jadwals->where('tanggal', '>=', now())->count();
        $mahasiswaCount = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)->count();
        $pengajuanBaru  = PengajuanPembimbing::where('dosen_id', $dosen->id)
                            ->where('status', 'pending')->count();

        return view('dosen.jadwal', compact(
            'dosen', 'jadwals', 'upcomingJadwal',
            'mahasiswaCount', 'pengajuanBaru'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA BIMBINGAN + PENGAJUAN MASUK
    |--------------------------------------------------------------------------
    */
    public function mahasiswa()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        // Mahasiswa yang sudah disetujui
        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $dosen->id)
                        ->orWhere('pembimbing2_id', $dosen->id)->get();

        // Pengajuan yang masih pending
        $pengajuanPending = PengajuanPembimbing::where('dosen_id', $dosen->id)
                        ->where('status', 'pending')
                        ->with('mahasiswa.prodi')
                        ->latest()->get();

        // Riwayat pengajuan (approved + rejected)
        $riwayatPengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
                        ->whereIn('status', ['approved', 'rejected'])
                        ->with('mahasiswa.prodi')
                        ->latest()->get();

        $mahasiswaCount = $mahasiswaBimbingan->count();
        $upcomingJadwal = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())->count();

        return view('dosen.mahasiswa', compact(
            'dosen', 'mahasiswaBimbingan', 'mahasiswaCount',
            'pengajuanPending', 'riwayatPengajuan', 'upcomingJadwal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING
    |--------------------------------------------------------------------------
    */
    /**
     * Kumpulan SK (Pembimbing + Pembahas) yang memuat dosen ini dan sudah
     * diterbitkan dekan. Hanya dosen bersangkutan yang melihatnya; mahasiswa tidak.
     */
    private function skItemsUntuk(Dosen $dosen)
    {
        // SK Pembimbing: dosen ini tercantum sebagai pembimbing 1/2, sudah diteruskan kaprodi, dan SK sudah terbit
        $skPembimbing = PengajuanSk::with('mahasiswa')
            ->where('kaprodi_approved', true)
            ->where(fn ($q) => $q->where('pembimbing1_id', $dosen->id)->orWhere('pembimbing2_id', $dosen->id))
            ->get()
            ->filter(fn ($p) => $p->sudahTerbit())
            ->map(fn ($p) => (object) [
                'jenis'    => 'SK Pembimbing',
                'mahasiswa'=> optional($p->mahasiswa)->nama ?? '-',
                'nim'      => optional($p->mahasiswa)->nim ?? '-',
                'peran'    => $p->pembimbing1_id == $dosen->id ? 'Pembimbing Utama' : 'Pembimbing Pendamping',
                'nomor_sk' => $p->nomor_sk,
                'tanggal'  => $p->tanggal_sk,
                'url'      => route('dosen.sk.pembimbing.unduh', $p->id),
            ]);

        // SK Pembahas: dosen ini tercantum sebagai pembahas 1/2, sudah diteruskan kaprodi, dan SK sudah terbit
        $skPembahas = Proposal::with('mahasiswa')
            ->whereNotNull('sk_pembahas_diteruskan_at')
            ->where(fn ($q) => $q->where('penguji1_id', $dosen->id)->orWhere('penguji2_id', $dosen->id))
            ->get()
            ->filter(fn ($p) => $p->sudahTerbitSkPembahas())
            ->map(fn ($p) => (object) [
                'jenis'    => 'SK Pembahas',
                'mahasiswa'=> optional($p->mahasiswa)->nama ?? '-',
                'nim'      => optional($p->mahasiswa)->nim ?? '-',
                'peran'    => $p->penguji1_id == $dosen->id ? 'Pembahas I' : 'Pembahas II',
                'nomor_sk' => $p->nomor_sk_pembahas,
                'tanggal'  => $p->tanggal_sk_pembahas,
                'url'      => route('dosen.sk.pembahas.unduh', $p->id),
            ]);

        return $skPembimbing->concat($skPembahas)
            ->sortByDesc(fn ($x) => $x->tanggal)->values();
    }

    public function sk()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $skItems = $this->skItemsUntuk($dosen);

        $mahasiswaCount = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)->count();
        $upcomingJadwal = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())->count();

        return view('dosen.sk', [
            'dosen'            => $dosen,
            'skItems'          => $skItems,
            'jumlahPembimbing' => $skItems->where('jenis', 'SK Pembimbing')->count(),
            'jumlahPembahas'   => $skItems->where('jenis', 'SK Pembahas')->count(),
            'mahasiswaCount'   => $mahasiswaCount,
            'upcomingJadwal'   => $upcomingJadwal,
        ]);
    }

    /** Unduh SK Pembimbing milik dosen ini (dosen lain tidak bisa mengakses). */
    public function skPembimbingUnduh($id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $sk = PengajuanSk::where('kaprodi_approved', true)
            ->where(fn ($q) => $q->where('pembimbing1_id', $dosen->id)->orWhere('pembimbing2_id', $dosen->id))
            ->findOrFail($id);

        if (!$sk->sudahTerbit()) {
            return redirect()->route('dosen.sk')->with('error', 'SK belum diterbitkan oleh dekan.');
        }

        $kurang = $sk->kekuranganData();
        if ($kurang) {
            return redirect()->route('dosen.sk')->with('error', 'SK belum bisa diunduh, data belum lengkap: ' . implode(', ', $kurang) . '.');
        }

        try {
            $file = $sk->buatFileSk();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('dosen.sk')->with('error', 'Gagal membuat file SK, silakan coba lagi.');
        }

        return response()->download($file, $sk->namaFileSk(), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    /** Unduh SK Pembahas milik dosen ini (dosen lain tidak bisa mengakses). */
    public function skPembahasUnduh($id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $proposal = Proposal::whereNotNull('sk_pembahas_diteruskan_at')
            ->where(fn ($q) => $q->where('penguji1_id', $dosen->id)->orWhere('penguji2_id', $dosen->id))
            ->findOrFail($id);

        if (!$proposal->sudahTerbitSkPembahas()) {
            return redirect()->route('dosen.sk')->with('error', 'SK belum diterbitkan oleh dekan.');
        }

        $kurang = $proposal->kekuranganDataSkPembahas();
        if ($kurang) {
            return redirect()->route('dosen.sk')->with('error', 'SK belum bisa diunduh, data belum lengkap: ' . implode(', ', $kurang) . '.');
        }

        try {
            $file = $proposal->buatFileSkPembahas();
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('dosen.sk')->with('error', 'Gagal membuat file SK, silakan coba lagi.');
        }

        return response()->download($file, $proposal->namaFileSkPembahas(), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $mahasiswaCount = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)->count();
        $upcomingJadwal = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())->count();
        $pengajuanBaru  = PengajuanPembimbing::where('dosen_id', $dosen->id)
                            ->where('status', 'pending')->count();

        return view('dosen.profile', compact(
            'dosen', 'mahasiswaCount', 'upcomingJadwal', 'pengajuanBaru'
        ));
    }
}