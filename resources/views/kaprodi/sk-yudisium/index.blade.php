<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Yudisium - Kaprodi</title>
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
    
        .sk-table thead th{font-size:.76rem;white-space:nowrap;}
        .sk-table tbody td{font-size:.84rem;}
        .btn-unduh{background:#27ae60;color:white;border:none;padding:.45rem .95rem;border-radius:8px;font-size:.78rem;cursor:pointer;text-decoration:none;white-space:nowrap;display:inline-block;}
        .btn-unduh:hover{background:#1e8449;color:white;}
        .btn-lihat{background:var(--light);color:var(--dark);border:none;padding:.45rem .8rem;border-radius:8px;font-size:.78rem;cursor:pointer;white-space:nowrap;font-family:'Poppins',sans-serif;}
        .btn-lihat:hover{background:#e2defc;}
        .detail-row td{background:#faf9ff;padding:1rem 1.25rem !important;}
        .detail-table{width:100%;border-collapse:collapse;}
        .detail-table th,.detail-table td{border:1px solid #eee;padding:.4rem .6rem;font-size:.8rem;text-align:left;}
        .detail-table th{background:var(--light);color:var(--dark);font-weight:600;}
</style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">SK Yudisium</span>
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

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            SK Yudisium yang sudah diberi nomor dan tanggal oleh dekan muncul di sini. File Word yang diunduh sudah memuat
            surat keputusan beserta lampiran daftar mahasiswa. Pengajuan baru dibuat di menu
            <a href="{{ route('kaprodi.yudisium.index') }}"><strong>Yudisium</strong></a>.
        </div>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <strong style="font-size:1rem;">Daftar SK Yudisium</strong>
                    <p style="color:var(--muted);font-size:.83rem;margin:0;">Total: {{ $daftar->count() }} pengajuan</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="custom-table sk-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor SK</th>
                            <th>Tanggal SK</th>
                            <th>Semester</th>
                            <th>Jumlah Mahasiswa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftar as $i => $sk)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{!! $sk->nomor_sk ? '<strong>' . e($sk->nomor_sk) . '</strong>' : '<span style="color:var(--muted);">Menunggu nomor dari dekan</span>' !!}</td>
                            <td>{{ $sk->tanggal_sk ? \App\Models\PengajuanSk::tanggalIndonesia($sk->tanggal_sk) : '-' }}</td>
                            <td>{{ $sk->tanggal_sk ? $sk->labelSemester() : '-' }}</td>
                            <td>{{ $sk->anggota_count }}</td>
                            <td>
                                @if($sk->sudahTerbit())
                                    <span class="chip ok"><i class="fas fa-check-circle"></i> Terbit</span>
                                @else
                                    <span class="chip wait"><i class="fas fa-hourglass-half"></i> Menunggu dekan</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;">
                                <button type="button" class="btn-lihat" data-target="detail-{{ $sk->id }}"><i class="fas fa-list"></i> Daftar</button>
                                @if($sk->sudahTerbit())
                                    <a href="{{ route('kaprodi.sk-yudisium.unduh', $sk->id) }}" class="btn-unduh"><i class="fas fa-file-word"></i> Unduh SK</a>
                                @endif
                            </td>
                        </tr>
                        <tr class="detail-row" id="detail-{{ $sk->id }}" style="display:none;">
                            <td colspan="7">
                                <table class="detail-table">
                                    <thead><tr><th>No</th><th>Nama</th><th>NIM</th><th>Tempat, Tanggal Lahir</th><th>IPK</th></tr></thead>
                                    <tbody>
                                        @foreach($sk->anggota->sortBy(fn ($a) => mb_strtolower(optional(optional($a->sidang)->mahasiswa)->nama ?? ''))->values() as $n => $a)
                                        <tr>
                                            <td>{{ $n + 1 }}</td>
                                            <td>{{ optional(optional($a->sidang)->mahasiswa)->nama ?? '-' }}</td>
                                            <td>{{ optional(optional($a->sidang)->mahasiswa)->nim ?? '-' }}</td>
                                            <td>{{ $a->tempatTanggalLahir() }}</td>
                                            <td>{{ number_format((float) $a->ipk, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><div class="empty-state"><i class="fas fa-file-signature"></i><p>Belum ada pengajuan SK Yudisium dari prodi Anda.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.querySelectorAll('.btn-lihat').forEach(b => b.addEventListener('click', () => {
        const r = document.getElementById(b.dataset.target);
        r.style.display = r.style.display === 'none' ? '' : 'none';
    }));
</script>
</body>
</html>