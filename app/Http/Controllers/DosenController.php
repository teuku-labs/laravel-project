<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Sk;
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

        $skDocuments    = $dosen->sk;
        $skCount        = $skDocuments->count();
        $pendingApproval = $skDocuments->where('status', 'pending')->count();

        // ✅ Pengajuan bimbingan yang belum direspons
        $pengajuanBaru  = PengajuanPembimbing::where('dosen_id', $dosen->id)
                            ->where('status', 'pending')
                            ->with('mahasiswa.prodi')
                            ->get();

        return view('dosen.dashboard', compact(
            'dosen', 'mahasiswaCount', 'jadwals',
            'upcomingJadwal', 'skDocuments', 'skCount',
            'pendingApproval', 'pengajuanBaru'
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

        $seminar = SeminarLkp::where('pembimbing1_id', $dosen->id)
            ->orWhere('penguji_id', $dosen->id)
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

        $proposalList = Proposal::where('pembimbing1_id', $dosen->id)
            ->with(['mahasiswa', 'pembimbing1', 'nilai'])
            ->latest()->get();

        return view('dosen.nilai-proposal', compact('dosen', 'proposalList'));
    }

    public function nilaiProposalStore(Request $request, $id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $proposal = Proposal::where('pembimbing1_id', $dosen->id)->findOrFail($id);

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiProposal::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiProposal::hitungNilaiHuruf($rataRata);

        NilaiProposal::updateOrCreate(
            ['proposal_id' => $proposal->id],
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

        $sidangList = Sidang::where('pembimbing_id', $dosen->id)
            ->with(['mahasiswa', 'pembimbing', 'nilai'])
            ->latest()->get();

        return view('dosen.nilai-sidang', compact('dosen', 'sidangList'));
    }

    public function nilaiSidangStore(Request $request, $id)
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $sidang = Sidang::where('pembimbing_id', $dosen->id)->findOrFail($id);

        $request->validate([
            'isi_materi'        => 'required|numeric|min:0|max:100',
            'penyajian'         => 'required|numeric|min:0|max:100',
            'penguasaan_materi' => 'required|numeric|min:0|max:100',
            'sikap_mental'      => 'required|numeric|min:0|max:100',
        ]);

        $rataRata   = NilaiSidang::hitungRataRata($request->isi_materi, $request->penyajian, $request->penguasaan_materi, $request->sikap_mental);
        $nilaiHuruf = NilaiSidang::hitungNilaiHuruf($rataRata);

        NilaiSidang::updateOrCreate(
            ['sidang_id' => $sidang->id],
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
    public function sk()
    {
        $dosen = $this->getDosen();
        if (!$dosen) return redirect()->route('login');

        $skDocuments    = $dosen->sk;
        $skCount        = $skDocuments->count();
        $pendingApproval = $skDocuments->where('status', 'pending')->count();
        $mahasiswaCount = Mahasiswa::where('pembimbing1_id', $dosen->id)
                            ->orWhere('pembimbing2_id', $dosen->id)->count();
        $upcomingJadwal = Jadwal::where('dosen_id', $dosen->id)
                            ->where('tanggal', '>=', now())->count();
        $pengajuanBaru  = PengajuanPembimbing::where('dosen_id', $dosen->id)
                            ->where('status', 'pending')->count();

        return view('dosen.sk', compact(
            'dosen', 'skDocuments', 'skCount', 'pendingApproval',
            'mahasiswaCount', 'upcomingJadwal', 'pengajuanBaru'
        ));
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