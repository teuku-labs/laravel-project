<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dekan;
use App\Models\SeminarLkp;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Proposal;
use App\Models\Sidang;
use App\Models\PengajuanPembimbing;
use App\Models\Dosen;
use App\Traits\SkSebagaiDosenTrait;
use App\Models\NilaiSeminarLkp;
use App\Models\NilaiProposal;
use App\Models\NilaiSidang;
use App\Models\PengajuanSk;
use App\Models\YudisiumSk;
use App\Support\SkDocx;

class DekanController extends Controller
{
    use SkSebagaiDosenTrait;

    /**
     * Ambil data dekan yang sedang login beserta relasinya.
     * PERBAIKAN: Menambahkan ->with(['user', 'prodi']) untuk eager loading
     * agar data relasi pasti ter-load dan tidak null di Blade.
     */
    private function getDekan()
    {
        return Dekan::with(['user', 'prodi'])
                    ->where('user_id', Auth::id())
                    ->first();
    }

    /**
     * Ambil data dosen yang terhubung dengan akun dekan yang sedang login
     * (dipakai untuk cek apakah dekan ini juga ditunjuk sebagai
     * pembimbing/penguji pada seminar tertentu, sehingga berhak input nilai).
     */
    private function getDosenSaya()
    {
        return Dosen::where('user_id', Auth::id())->first();
    }

    /**
     * ID baris milik akun ini di tabel `dosen`.
     * Kolom pengajuan_pembimbings.dosen_id, mahasiswa.pembimbing1_id/pembimbing2_id
     * dan jadwal.dosen_id semuanya merujuk ke dosen.id, BUKAN users.id.
     * Mengembalikan 0 kalau akun belum punya baris dosen, supaya query tidak
     * pernah cocok dengan data (where(..., null) akan berubah jadi IS NULL).
     */
    private function dosenId(): int
    {
        return (int) ($this->getDosenSaya()->id ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $dekan = $this->getDekan();
        if (!$dekan) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Data Dekan tidak ditemukan.']);
        }

        $totalMahasiswa = Mahasiswa::count();
        $totalSeminar   = SeminarLkp::count();
        $sudahDijadwal  = Jadwal::where('jenis', 'lkp')->count();
        $belumDijadwal  = SeminarLkp::whereNull('tanggal_seminar')->count();

        $jadwalTerbaru = Jadwal::with(['mahasiswa', 'dosen'])
                            ->where('jenis', 'lkp')
                            ->orderBy('tanggal', 'asc')
                            ->take(5)->get();

        // ✅ Fitur Dosen Pembimbing
        $pengajuanBimbingan = PengajuanPembimbing::where('dosen_id', $this->dosenId())
                                ->where('status', 'pending')
                                ->with('mahasiswa.prodi')->get();

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $this->dosenId())
                                ->orWhere('pembimbing2_id', $this->dosenId())->count();

        return view('dekan.dashboard', compact(
            'dekan', 'totalMahasiswa', 'totalSeminar',
            'sudahDijadwal', 'belumDijadwal', 'jadwalTerbaru',
            'pengajuanBimbingan', 'mahasiswaBimbingan'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function seminar()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $seminarList = SeminarLkp::with(['mahasiswa', 'dosen'])->latest()->get();
        return view('dekan.seminar', compact('dekan', 'seminarList'));
    }

    /*
    |--------------------------------------------------------------------------
    | NILAI SEMINAR LKP
    |--------------------------------------------------------------------------
    */
    public function nilaiIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $seminarList = SeminarLkp::with(['mahasiswa', 'dosen', 'penguji', 'nilai'])
            ->latest()->get();

        return view('dekan.nilai-lkp', compact('dekan', 'seminarList', 'dosenSaya'));
    }

    public function nilaiStore(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $seminar = SeminarLkp::findOrFail($id);

        // Dekan hanya boleh input nilai jika ia juga ditunjuk sebagai
        // dosen pembimbing atau dosen penguji pada seminar tersebut.
        $berhak = $dosenSaya && ($seminar->pembimbing1_id == $dosenSaya->id || $seminar->penguji_id == $dosenSaya->id);
        if (!$berhak) {
            return back()->withErrors(['nilai' => 'Anda hanya bisa memberi nilai untuk seminar yang Anda menjadi pembimbing/penguji.']);
        }

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
                'dinilai_oleh'      => $dekan->nama,
                'dinilai_oleh_role' => 'Dekan',
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
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $proposalList = Proposal::with(['mahasiswa', 'pembimbing1', 'penguji1', 'penguji2', 'nilaiPenguji'])->latest()->get();

        return view('dekan.nilai-proposal', compact('dekan', 'proposalList', 'dosenSaya'));
    }

    public function nilaiProposalStore(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $proposal = Proposal::findOrFail($id);

        $berhak = $proposal->bolehDinilaiOleh($dosenSaya);
        if (!$berhak) {
            return back()->withErrors(['nilai' => 'Anda hanya bisa memberi nilai untuk proposal yang Anda menjadi pembahas/penguji.']);
        }

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiProposal::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiProposal::hitungNilaiHuruf($rataRata);

        NilaiProposal::updateOrCreate(
            ['proposal_id' => $proposal->id, 'dosen_id' => $dosenSaya->id],
            [
                'isi_materi'        => $request->isi_materi,
                'penyajian'         => $request->penyajian,
                'penguasaan_materi' => $request->penguasaan_materi,
                'sikap_mental'      => $request->sikap_mental,
                'rata_rata'         => $rataRata,
                'nilai_huruf'       => $nilaiHuruf,
                'dinilai_oleh'      => $dekan->nama,
                'dinilai_oleh_role' => 'Dekan',
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
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $sidangList = Sidang::with(['mahasiswa', 'pembimbing', 'penguji1', 'penguji2', 'nilaiPenguji'])->latest()->get();

        return view('dekan.nilai-sidang', compact('dekan', 'sidangList', 'dosenSaya'));
    }

    public function nilaiSidangStore(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosenSaya = $this->getDosenSaya();

        $sidang = Sidang::findOrFail($id);

        $berhak = $sidang->bolehDinilaiOleh($dosenSaya);
        if (!$berhak) {
            return back()->withErrors(['nilai' => 'Anda hanya bisa memberi nilai untuk sidang yang Anda menjadi pembahas/penguji.']);
        }

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiSidang::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiSidang::hitungNilaiHuruf($rataRata);

        NilaiSidang::updateOrCreate(
            ['sidang_id' => $sidang->id, 'dosen_id' => $dosenSaya->id],
            [
                'isi_materi'        => $request->isi_materi,
                'penyajian'         => $request->penyajian,
                'penguasaan_materi' => $request->penguasaan_materi,
                'sikap_mental'      => $request->sikap_mental,
                'rata_rata'         => $rataRata,
                'nilai_huruf'       => $nilaiHuruf,
                'dinilai_oleh'      => $dekan->nama,
                'dinilai_oleh_role' => 'Dekan',
            ]
        );

        return back()->with('success', 'Nilai sidang skripsi berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL SEMINAR
    |--------------------------------------------------------------------------
    */
    public function jadwal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $jadwalList = Jadwal::with(['mahasiswa', 'dosen'])->orderBy('tanggal', 'asc')->get();
        return view('dekan.jadwal', compact('dekan', 'jadwalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROPOSAL
    |--------------------------------------------------------------------------
    */
    public function proposal()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposalList = Proposal::with(['mahasiswa.prodi', 'pembimbing1'])->latest()->get();
        return view('dekan.proposal', compact('dekan', 'proposalList'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIDANG
    |--------------------------------------------------------------------------
    */
    public function sidang()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $sidangList = Sidang::with(['mahasiswa.prodi', 'pembimbing'])->latest()->get();
        return view('dekan.sidang', compact('dekan', 'sidangList'));
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ FITUR DOSEN PEMBIMBING — Pengajuan Bimbingan
    |--------------------------------------------------------------------------
    */
    public function bimbinganIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $pengajuanPending = PengajuanPembimbing::where('dosen_id', $this->dosenId())
                            ->where('status', 'pending')
                            ->with('mahasiswa.prodi')->latest()->get();

        $riwayatPengajuan = PengajuanPembimbing::where('dosen_id', $this->dosenId())
                            ->whereIn('status', ['approved', 'rejected'])
                            ->with('mahasiswa.prodi')->latest()->get();

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $this->dosenId())
                                ->orWhere('pembimbing2_id', $this->dosenId())
                                ->with('prodi')->get();

        $mahasiswaCount = $mahasiswaBimbingan->count();

        $dosenId = $this->dosenId();

        return view('dekan.bimbingan', compact(
            'dekan', 'pengajuanPending', 'riwayatPengajuan',
            'mahasiswaBimbingan', 'mahasiswaCount', 'dosenId'
        ));
    }

    public function bimbinganApprove($id)
    {
        $dekan     = $this->getDekan();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $this->dosenId())->firstOrFail();

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $jenis     = explode('|', $pengajuan->catatan)[0];

        if ($jenis === 'pembimbing1') {
            $mahasiswa->pembimbing1_id = $this->dosenId();
        } else {
            $mahasiswa->pembimbing2_id = $this->dosenId();
        }
        $mahasiswa->save();

        $pengajuan->update(['status' => 'approved']);

        PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', '!=', $id)
            ->where('catatan', 'like', $jenis . '%')
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Permintaan bimbingan dari ' . $mahasiswa->nama . ' disetujui.');
    }

    public function bimbinganReject(Request $request, $id)
    {
        $dekan     = $this->getDekan();
        $pengajuan = PengajuanPembimbing::where('id', $id)
                        ->where('dosen_id', $this->dosenId())->firstOrFail();

        $jenis  = explode('|', $pengajuan->catatan)[0];
        $alasan = $request->alasan ?: 'Tidak ada alasan';

        $pengajuan->update(['status' => 'rejected', 'catatan' => $jenis . '|' . $alasan]);
        return back()->with('success', 'Permintaan bimbingan ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | ✅ JADWAL SAYA (sebagai pembimbing)
    |--------------------------------------------------------------------------
    */
    public function jadwalSaya()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $jadwals = Jadwal::where('dosen_id', $this->dosenId())
                    ->with('mahasiswa')->orderBy('tanggal', 'asc')->get();

        return view('dekan.jadwal-saya', compact('dekan', 'jadwals'));
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD SK (sebagai pembimbing / pembahas)
    |--------------------------------------------------------------------------
    | Sama seperti halaman "Download SK" milik dosen: hanya SK yang memuat nama
    | akun ini, dan baru bisa diunduh setelah diterbitkan dekan.
    */
    public function skSaya()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $dosen   = $this->getDosenSaya();
        $skItems = $dosen
            ? $this->skItemsUntukDosen($dosen, 'dekan.sk-saya.pembimbing.unduh', 'dekan.sk-saya.pembahas.unduh')
            : collect();

        return view('dekan.sk-saya', [
            'dekan'          => $dekan,
            'skItems'          => $skItems,
            'punyaDataDosen'   => (bool) $dosen,
            'jumlahPembimbing' => $skItems->where('jenis', 'SK Pembimbing')->count(),
            'jumlahPembahas'   => $skItems->where('jenis', 'SK Pembahas')->count(),
        ]);
    }

    public function skSayaPembimbingUnduh($id)
    {
        return $this->unduhSkPembimbingSaya($this->getDosenSaya(), $id, 'dekan.sk-saya');
    }

    public function skSayaPembahasUnduh($id)
    {
        return $this->unduhSkPembahasSaya($this->getDosenSaya(), $id, 'dekan.sk-saya');
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $mahasiswaBimbingan = Mahasiswa::where('pembimbing1_id', $this->dosenId())
                                ->orWhere('pembimbing2_id', $this->dosenId())->count();
        $pengajuanBaru      = PengajuanPembimbing::where('dosen_id', $this->dosenId())
                                ->where('status', 'pending')->count();

        return view('dekan.profile', compact('dekan', 'mahasiswaBimbingan', 'pengajuanBaru'));
    }

    /*
    |--------------------------------------------------------------------------
    | SK PEMBIMBING
    | Alur: mahasiswa mengajukan -> kaprodi menyetujui -> dekan mengisi
    | nomor SK + tanggal SK -> SK bisa dicetak dari template Word.
    |--------------------------------------------------------------------------
    */
    public function skPembimbingIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $pengajuanSks = PengajuanSk::with([
                'mahasiswa.prodi', 'mahasiswa.seminarLkp', 'mahasiswa.proposal',
                'pembimbing1', 'pembimbing2',
            ])
            ->where('kaprodi_approved', true)
            ->orderByRaw('(tanggal_sk IS NULL) DESC')   // yang belum diberi nomor di atas
            ->latest()
            ->get();

        $totalSk       = $pengajuanSks->count();
        $belumTerbit   = $pengajuanSks->filter(fn ($p) => !$p->sudahTerbit())->count();
        $sudahTerbit   = $totalSk - $belumTerbit;

        return view('dekan.sk-pembimbing.index', compact(
            'dekan', 'pengajuanSks', 'totalSk', 'belumTerbit', 'sudahTerbit'
        ));
    }

    public function skPembimbingSimpan(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $pengajuan = PengajuanSk::where('kaprodi_approved', true)->findOrFail($id);

        $request->validate([
            'nomor_sk'   => 'required|string|max:100|unique:pengajuan_sks,nomor_sk,' . $pengajuan->id,
            'tanggal_sk' => 'required|date',
        ], [
            'nomor_sk.required'   => 'Nomor SK wajib diisi.',
            'nomor_sk.unique'     => 'Nomor SK tersebut sudah dipakai SK lain.',
            'tanggal_sk.required' => 'Tanggal SK wajib diisi.',
            'tanggal_sk.date'     => 'Tanggal SK tidak valid.',
        ]);

        $pengajuan->update([
            'nomor_sk'   => trim($request->nomor_sk),
            'tanggal_sk' => $request->tanggal_sk,
        ]);

        return back()->with('success', 'Nomor dan tanggal SK Pembimbing berhasil disimpan.');
    }

    public function skPembimbingCetak($id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $pengajuan = PengajuanSk::with([
                'mahasiswa.prodi', 'mahasiswa.seminarLkp', 'mahasiswa.proposal',
                'pembimbing1', 'pembimbing2',
            ])
            ->where('kaprodi_approved', true)
            ->findOrFail($id);

        // Tanda tangan + stempel ada di template, jadi hanya dicetak setelah SK resmi terbit.
        if (!$pengajuan->sudahTerbit()) {
            return back()->withErrors(['sk' => 'Isi nomor SK dan tanggal SK terlebih dahulu sebelum mencetak.']);
        }

        $kurang = $pengajuan->kekuranganData();
        if ($kurang) {
            return back()->withErrors(['sk' => 'SK belum bisa dicetak, data belum lengkap: ' . implode(', ', $kurang) . '.']);
        }

        try {
            $file = $pengajuan->buatFileSk();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['sk' => 'Gagal membuat file SK: ' . $e->getMessage()]);
        }

        return response()
            ->download($file, $pengajuan->namaFileSk(), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->deleteFileAfterSend(true);
    }


    /*
    |--------------------------------------------------------------------------
    | SK PEMBAHAS
    | Alur: kaprodi menetapkan dua dosen pembahas -> dekan mengisi
    | nomor SK + tanggal SK -> SK bisa dicetak dari template Word.
    |--------------------------------------------------------------------------
    */
    public function skPembahasIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposalList = Proposal::with(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'penguji1', 'penguji2'])
            ->whereNotNull('penguji1_id')
            ->whereNotNull('penguji2_id')
            ->whereNotNull('sk_pembahas_diteruskan_at')   // sudah diteruskan kaprodi
            ->orderByRaw('(tanggal_sk_pembahas IS NULL) DESC')   // yang belum diberi nomor di atas
            ->latest()
            ->get();

        $totalSk     = $proposalList->count();
        $belumTerbit = $proposalList->filter(fn ($p) => !$p->sudahTerbitSkPembahas())->count();
        $sudahTerbit = $totalSk - $belumTerbit;

        return view('dekan.sk-pembahas.index', compact(
            'dekan', 'proposalList', 'totalSk', 'belumTerbit', 'sudahTerbit'
        ));
    }

    public function skPembahasSimpan(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposal = Proposal::whereNotNull('penguji1_id')->whereNotNull('penguji2_id')
            ->whereNotNull('sk_pembahas_diteruskan_at')->findOrFail($id);

        $request->validate([
            'nomor_sk'   => 'required|string|max:100|unique:proposals,nomor_sk_pembahas,' . $proposal->id,
            'tanggal_sk' => 'required|date',
        ], [
            'nomor_sk.required'   => 'Nomor SK wajib diisi.',
            'nomor_sk.unique'     => 'Nomor SK tersebut sudah dipakai SK lain.',
            'tanggal_sk.required' => 'Tanggal SK wajib diisi.',
            'tanggal_sk.date'     => 'Tanggal SK tidak valid.',
        ]);

        $proposal->update([
            'nomor_sk_pembahas'   => trim($request->nomor_sk),
            'tanggal_sk_pembahas' => $request->tanggal_sk,
        ]);

        return back()->with('success', 'Nomor dan tanggal SK Pembahas berhasil disimpan.');
    }

    public function skPembahasCetak($id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $proposal = Proposal::with(['mahasiswa.prodi', 'mahasiswa.seminarLkp', 'penguji1', 'penguji2'])
            ->whereNotNull('penguji1_id')
            ->whereNotNull('penguji2_id')
            ->whereNotNull('sk_pembahas_diteruskan_at')   // sudah diteruskan kaprodi
            ->findOrFail($id);

        // Tanda tangan + stempel ada di template, jadi hanya dicetak setelah SK resmi terbit.
        if (!$proposal->sudahTerbitSkPembahas()) {
            return back()->withErrors(['sk' => 'Isi nomor SK dan tanggal SK terlebih dahulu sebelum mencetak.']);
        }

        $kurang = $proposal->kekuranganDataSkPembahas();
        if ($kurang) {
            return back()->withErrors(['sk' => 'SK belum bisa dicetak, data belum lengkap: ' . implode(', ', $kurang) . '.']);
        }

        try {
            $file = $proposal->buatFileSkPembahas();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['sk' => 'Gagal membuat file SK: ' . $e->getMessage()]);
        }

        return response()
            ->download($file, $proposal->namaFileSkPembahas(), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->deleteFileAfterSend(true);
    }

    /*
    |--------------------------------------------------------------------------
    | SK YUDISIUM (kolektif)
    | Kaprodi memilih mahasiswa yang lulus sidang + mengisi IPK lalu mengajukan.
    | Dekan hanya mengisi nomor SK dan tanggal SK; setelah itu SK terbit dan
    | (beserta lampiran nama) bisa dilihat/diunduh kaprodi prodi bersangkutan.
    |--------------------------------------------------------------------------
    */
    public function skYudisiumIndex()
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $daftar = YudisiumSk::with(['prodi', 'anggota.sidang.mahasiswa'])
            ->withCount('anggota')
            ->get()
            ->sortBy(fn ($sk) => [
                $sk->status === YudisiumSk::DIAJUKAN ? 0 : 1,
                -1 * ($sk->diajukan_at ? $sk->diajukan_at->timestamp : 0),
            ])
            ->values();

        $jumlahMenunggu = $daftar->where('status', YudisiumSk::DIAJUKAN)->count();
        $jumlahTerbit   = $daftar->where('status', YudisiumSk::TERBIT)->count();

        return view('dekan.sk-yudisium.index', compact('dekan', 'daftar', 'jumlahMenunggu', 'jumlahTerbit'));
    }

    public function skYudisiumSimpan(Request $request, $id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $sk = YudisiumSk::with('anggota.sidang')->findOrFail($id);

        $request->validate([
            'nomor_sk'   => 'required|string|max:100|unique:yudisium_sks,nomor_sk,' . $sk->id,
            'tanggal_sk' => 'required|date',
        ], [
            'nomor_sk.required'   => 'Nomor SK wajib diisi.',
            'nomor_sk.unique'     => 'Nomor SK tersebut sudah dipakai SK Yudisium lain.',
            'tanggal_sk.required' => 'Tanggal SK wajib diisi.',
            'tanggal_sk.date'     => 'Tanggal SK tidak valid.',
        ]);

        // Tanggal SK tidak boleh lebih awal dari tanggal sidang terakhir di daftar (bila tercatat).
        $terakhir = $sk->anggota
            ->map(fn ($a) => optional($a->sidang)->tanggal_sidang)
            ->filter()
            ->map(fn ($t) => \Carbon\Carbon::parse($t)->startOfDay())
            ->max();

        if ($terakhir && \Carbon\Carbon::parse($request->tanggal_sk)->startOfDay()->lt($terakhir)) {
            return back()->withInput()->withErrors([
                'tanggal_sk' => 'Tanggal SK tidak boleh lebih awal dari tanggal sidang terakhir ('
                    . \App\Models\PengajuanSk::tanggalIndonesia($terakhir) . ').',
            ]);
        }

        $sk->update([
            'nomor_sk'   => trim($request->nomor_sk),
            'tanggal_sk' => $request->tanggal_sk,
            'status'     => YudisiumSk::TERBIT,
        ]);

        return back()->with('success', 'SK Yudisium nomor ' . $sk->nomor_sk . ' tersimpan dan sudah bisa diunduh kaprodi.');
    }

    public function skYudisiumCetak($id)
    {
        $dekan = $this->getDekan();
        if (!$dekan) return redirect()->route('login');

        $sk = YudisiumSk::with('prodi')->findOrFail($id);

        try {
            $file = $sk->buatFileSk();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['sk' => 'Gagal membuat file SK: ' . $e->getMessage()]);
        }

        return response()
            ->download($file, $sk->namaFileSk(), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->deleteFileAfterSend(true);
    }
}