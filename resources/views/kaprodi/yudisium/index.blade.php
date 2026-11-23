<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yudisium - Kaprodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#6c5ce7;--dark:#5a4bd1;--light:#f0eeff;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,0.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}
        .menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .uname{font-weight:600;font-size:.9rem;}
        .urole{font-size:.75rem;color:var(--muted);}
        .content{padding:2rem;}
        .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.5rem;}
        .stat-mini{background:white;border-radius:12px;padding:1rem;box-shadow:0 3px 10px rgba(0,0,0,.05);text-align:center;}
        .stat-mini .value{font-size:1.8rem;font-weight:700;}
        .stat-mini .label{font-size:.8rem;color:var(--muted);}
        .info-box{background:var(--light);border-left:4px solid var(--primary);border-radius:10px;padding:.9rem 1.1rem;font-size:.85rem;margin-bottom:1.5rem;}
        .table-card{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);}
        .table-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:1rem;}
        .search-box{position:relative;min-width:250px;}
        .search-box input{padding:.7rem 1rem .7rem 2.4rem;border:2px solid #eee;border-radius:10px;width:100%;font-family:'Poppins',sans-serif;font-size:.88rem;}
        .search-box input:focus{border-color:var(--primary);outline:none;}
        .search-box i{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);}
        .custom-table{width:100%;border-collapse:collapse;}
        .custom-table thead th{background:var(--light);color:var(--dark);font-weight:600;font-size:.78rem;padding:.7rem .6rem;text-align:center;border:1px solid #eee;vertical-align:middle;}
        .custom-table tbody td{padding:.6rem;border:1px solid #eee;font-size:.85rem;text-align:center;vertical-align:middle;}
        .custom-table tbody tr:hover{background:var(--light);}
        .custom-table tbody td.text-start{text-align:left;}
        .chip{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:20px;font-size:.74rem;font-weight:600;white-space:nowrap;}
        .chip.ok{background:#e8f8f0;color:#27ae60;}
        .chip.wait{background:#fff4e0;color:#e67e22;}
        .chip.done{background:#e8f0ff;color:#2d6cdf;}
        .alasan{font-size:.76rem;color:var(--muted);text-align:left;margin-top:.35rem;line-height:1.35;}
        .btn-kirim{background:var(--primary);color:white;border:none;padding:.45rem .95rem;border-radius:8px;font-size:.78rem;cursor:pointer;white-space:nowrap;font-family:'Poppins',sans-serif;}
        .btn-kirim:hover{background:var(--dark);}
        .btn-kirim:disabled{background:#d6d6dc;cursor:not-allowed;}
        .btn-semua{background:linear-gradient(135deg,var(--primary),var(--dark));color:white;border:none;padding:.7rem 1.3rem;border-radius:10px;font-size:.88rem;font-weight:500;cursor:pointer;font-family:'Poppins',sans-serif;}
        .btn-semua:disabled{background:#d6d6dc;cursor:not-allowed;}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);}
        .empty-state i{font-size:3rem;color:#dee2e6;margin-bottom:.75rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    
        .yud-table thead th{font-size:.74rem;white-space:nowrap;}
        .yud-table tbody td{font-size:.82rem;}
        .yud-table tbody tr.dipilih{background:#f6f4ff;}
        .f-input{padding:.35rem .5rem;border:1.5px solid #ddd;border-radius:6px;font-family:'Poppins',sans-serif;font-size:.82rem;}
        .f-input:focus{border-color:var(--primary);outline:none;}
        .f-input:disabled{background:#f4f4f6;color:#9aa0a6;}
        .f-input.is-bad{border-color:#e74c3c;background:#fff5f4;}
        .ipk{width:70px;text-align:center;}
        .tempat{width:170px;}
        .tgl{width:150px;}
        .pilih{width:17px;height:17px;cursor:pointer;accent-color:var(--primary);}
        .warn{color:#e67e22;font-size:.72rem;display:block;margin-top:.2rem;text-align:left;}
        .menunggu-item{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;padding:.7rem 0;border-bottom:1px dashed #eee;}
        .menunggu-item:last-child{border-bottom:none;}
        .btn-batal{background:#fff;color:#c0392b;border:1.5px solid #e6b0aa;padding:.35rem .8rem;border-radius:8px;font-size:.78rem;cursor:pointer;font-family:'Poppins',sans-serif;}
        .btn-batal:hover{background:#fdecea;}
</style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">Yudisium</span>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="avatar">{{ substr($kaprodi->nama ?? 'K', 0, 1) }}</div>
            <div><div class="uname">{{ $kaprodi->nama ?? '-' }}</div><div class="urole">Kaprodi</div></div>
        </div>
    </nav>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            @php $semuaError = $errors->all(); @endphp
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                @if(count($semuaError) === 1)
                    {{ $semuaError[0] }}
                @else
                    <strong>Periksa kembali:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach(array_slice($semuaError, 0, 8) as $err)<li>{{ $err }}</li>@endforeach
                        @if(count($semuaError) > 8)<li>dan {{ count($semuaError) - 8 }} kesalahan lainnya.</li>@endif
                    </ul>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="stats-row">
            <div class="stat-mini"><div class="value" style="color:#27ae60;">{{ $kandidat->count() }}</div><div class="label">Lulus sidang, siap diajukan</div></div>
            <div class="stat-mini"><div class="value" style="color:#e67e22;">{{ $belumLulus }}</div><div class="label">Sidang belum lulus / nilai belum lengkap</div></div>
            <div class="stat-mini"><div class="value" style="color:#2d6cdf;">{{ $menunggu->sum('anggota_count') }}</div><div class="label">Mahasiswa menunggu dekan</div></div>
            <div class="stat-mini"><div class="value">{{ $jumlahTerbit }}</div><div class="label">SK Yudisium sudah terbit</div></div>
        </div>

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            Mahasiswa muncul di sini otomatis setelah seluruh dosen penguji menginput nilai sidang dan nilainya lulus.
            Centang mahasiswa yang ikut yudisium, isi <strong>IPK</strong>, periksa tempat dan tanggal lahir
            (terisi dari data LKP, boleh dikoreksi), lalu ajukan ke dekan. Setelah dekan mengisi nomor dan tanggal SK,
            SK lengkap dengan lampiran nama bisa diunduh di menu <a href="{{ route('kaprodi.sk-yudisium.index') }}"><strong>SK Yudisium</strong></a>.
        </div>

        @if($menunggu->isNotEmpty())
        <div class="table-card" style="margin-bottom:1.5rem;">
            <strong style="font-size:1rem;"><i class="fas fa-hourglass-half" style="color:#e67e22;"></i> Pengajuan menunggu dekan</strong>
            <p style="color:var(--muted);font-size:.83rem;margin:.15rem 0 .5rem;">Bisa ditarik kembali selama dekan belum mengisi nomor SK, misalnya bila ada IPK yang salah.</p>
            @foreach($menunggu as $m)
                <div class="menunggu-item">
                    <div>
                        <strong>{{ $m->anggota_count }} mahasiswa</strong>
                        <span style="color:var(--muted);font-size:.82rem;"> &middot; diajukan {{ optional($m->diajukan_at)->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    <form action="{{ route('kaprodi.yudisium.batal', $m->id) }}" method="POST"
                          onsubmit="return confirm('Tarik kembali pengajuan {{ $m->anggota_count }} mahasiswa ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-batal"><i class="fas fa-undo"></i> Tarik kembali</button>
                    </form>
                </div>
            @endforeach
        </div>
        @endif

        <form id="formYudisium" action="{{ route('kaprodi.yudisium.ajukan') }}" method="POST"
              onsubmit="return confirm('Ajukan ' + document.getElementById('jumlahDipilih').textContent + ' mahasiswa ke dekan untuk SK Yudisium?');">
            @csrf
            <div class="table-card">
                <div class="table-header">
                    <div>
                        <strong style="font-size:1rem;">Mahasiswa Lulus Sidang</strong>
                        <p style="color:var(--muted);font-size:.83rem;margin:0;">Terpilih: <strong id="jumlahDipilih">0</strong> dari {{ $kandidat->count() }} mahasiswa</p>
                    </div>
                    <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari mahasiswa...">
                        </div>
                        <button type="submit" class="btn-semua" id="btnAjukan" disabled>
                            <i class="fas fa-paper-plane"></i> Ajukan ke Dekan
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="custom-table yud-table" id="yudTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="pilih" id="pilihSemua" title="Pilih semua yang terlihat"></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Angkatan</th>
                                <th>Tgl. Sidang</th>
                                <th>Nilai Sidang</th>
                                <th>IPK</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kandidat as $i => $s)
                            @php
                                $mhs     = $s->mahasiswa;
                                $lkp     = optional($mhs)->seminarLkp;
                                $nilai   = $s->nilaiAkhir();
                                $dipilih = in_array($s->id, array_map('intval', (array) old('sidang_ids', [])));
                                $tempat  = old("tempat_lahir.{$s->id}", $lkp->tempat_lahir ?? '');
                                $tgl     = old("tanggal_lahir.{$s->id}", ($lkp && $lkp->tanggal_lahir) ? \Carbon\Carbon::parse($lkp->tanggal_lahir)->format('Y-m-d') : '');
                            @endphp
                            <tr data-row>
                                <td><input type="checkbox" class="pilih pilih-baris" name="sidang_ids[]" value="{{ $s->id }}" {{ $dipilih ? 'checked' : '' }}></td>
                                <td>{{ $i + 1 }}</td>
                                <td class="text-start"><strong>{{ $mhs->nama ?? '-' }}</strong></td>
                                <td>{{ $mhs->nim ?? '-' }}</td>
                                <td>{{ $mhs->angkatan ?? '-' }}</td>
                                <td>{{ $s->tanggal_sidang ? \Carbon\Carbon::parse($s->tanggal_sidang)->format('d/m/Y') : '-' }}</td>
                                <td><span class="chip ok">{{ number_format($nilai['rata_rata'], 2) }} ({{ $nilai['nilai_huruf'] }})</span></td>
                                <td>
                                    <input type="text" inputmode="decimal" maxlength="4" name="ipk[{{ $s->id }}]" class="f-input ipk {{ $errors->has("ipk.{$s->id}") ? 'is-bad' : '' }}"
                                           placeholder="3.75" value="{{ old("ipk.{$s->id}") }}" disabled>
                                </td>
                                <td>
                                    <input type="text" maxlength="100" name="tempat_lahir[{{ $s->id }}]" class="f-input tempat {{ $errors->has("tempat_lahir.{$s->id}") ? 'is-bad' : '' }}"
                                           placeholder="Tempat lahir" value="{{ $tempat }}" disabled>
                                    @unless($lkp)<span class="warn"><i class="fas fa-exclamation-triangle"></i> Belum ada data LKP, isi manual</span>@endunless
                                </td>
                                <td>
                                    <input type="date" name="tanggal_lahir[{{ $s->id }}]" class="f-input tgl {{ $errors->has("tanggal_lahir.{$s->id}") ? 'is-bad' : '' }}"
                                           value="{{ $tgl }}" disabled>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10"><div class="empty-state"><i class="fas fa-user-graduate"></i><p>Belum ada mahasiswa prodi Anda yang lulus sidang dan belum masuk pengajuan.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));

    const baris     = Array.from(document.querySelectorAll('#yudTable tbody tr[data-row]'));
    const pilihSemua = document.getElementById('pilihSemua');
    const jumlah    = document.getElementById('jumlahDipilih');
    const btnAjukan = document.getElementById('btnAjukan');

    // Kolom isian hanya aktif (dan wajib) pada baris yang dicentang.
    function sinkron() {
        let n = 0, terlihat = 0, terlihatDipilih = 0;
        baris.forEach(r => {
            const cb = r.querySelector('.pilih-baris');
            r.querySelectorAll('.f-input').forEach(i => { i.disabled = !cb.checked; i.required = cb.checked; });
            r.classList.toggle('dipilih', cb.checked);
            if (cb.checked) n++;
            if (r.style.display !== 'none') { terlihat++; if (cb.checked) terlihatDipilih++; }
        });
        jumlah.textContent = n;
        btnAjukan.disabled = n === 0;
        pilihSemua.checked = terlihat > 0 && terlihatDipilih === terlihat;
    }
    baris.forEach(r => r.querySelector('.pilih-baris').addEventListener('change', sinkron));
    pilihSemua.addEventListener('change', function () {
        baris.forEach(r => { if (r.style.display !== 'none') r.querySelector('.pilih-baris').checked = this.checked; });
        sinkron();
    });
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        baris.forEach(r => { r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none'; });
        sinkron();
    });
    sinkron();
</script>
</body>
</html>