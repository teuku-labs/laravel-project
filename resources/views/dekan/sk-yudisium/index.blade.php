<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Yudisium - Dekan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#e17055;--dark:#c0392b;--light:#fdf0ee;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
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
        .nilai-input{width:65px;padding:.35rem;border:1.5px solid #ddd;border-radius:6px;text-align:center;font-family:'Poppins',sans-serif;font-size:.85rem;}
        .nilai-input:focus{border-color:var(--primary);outline:none;}
        .nilai-input:disabled{background:#f4f4f6;color:var(--muted);}
        .rata-cell{font-weight:600;color:var(--dark);}
        .badge-huruf{display:inline-block;min-width:28px;padding:.25rem .5rem;border-radius:6px;font-weight:700;font-size:.8rem;background:var(--light);color:var(--dark);}
        .btn-save{background:var(--primary);color:white;border:none;padding:.4rem .9rem;border-radius:8px;font-size:.78rem;cursor:pointer;white-space:nowrap;}
        .btn-save:hover{background:var(--dark);}
        .badge-locked{font-size:.72rem;color:var(--muted);}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);}
        .empty-state i{font-size:3rem;color:#dee2e6;margin-bottom:.75rem;}
        .stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.25rem;}
        .stat-card{background:white;border-radius:14px;padding:1rem 1.25rem;box-shadow:0 5px 20px rgba(0,0,0,.05);}
        .stat-card .num{font-size:1.6rem;font-weight:700;color:var(--dark);line-height:1.1;}
        .stat-card .lbl{font-size:.78rem;color:var(--muted);}
        .sk-table thead th{font-size:.74rem;white-space:nowrap;}
        .sk-table tbody td{font-size:.8rem;}
        .sk-input{padding:.35rem .5rem;border:1.5px solid #ddd;border-radius:6px;font-family:'Poppins',sans-serif;font-size:.8rem;}
        .sk-input:focus{border-color:var(--primary);outline:none;}
        .sk-nomor{width:175px;}
        .sk-tanggal{width:140px;}
        .btn-print{background:#27ae60;color:white;border:none;padding:.4rem .8rem;border-radius:8px;font-size:.78rem;cursor:pointer;text-decoration:none;white-space:nowrap;display:inline-block;}
        .btn-print:hover{background:#1e8449;color:white;}
        .btn-print.disabled{background:#c9ced3;cursor:not-allowed;pointer-events:none;}
        .pill{display:inline-block;padding:.2rem .6rem;border-radius:20px;font-size:.72rem;font-weight:600;white-space:nowrap;}
        .pill-wait{background:#fff4e0;color:#e67e22;}
        .pill-ok{background:#e6f6ec;color:#1e8449;}
        .warn{color:#e67e22;font-size:.75rem;}
        @media(max-width:768px){.stat-row{grid-template-columns:1fr;}}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    
        .yud-card{background:white;border-radius:16px;padding:1.25rem 1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:1.25rem;}
        .yud-card.menunggu{border-left:5px solid #e67e22;}
        .yud-card.terbit{border-left:5px solid #27ae60;}
        .yud-head{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;}
        .yud-form{display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;}
        .yud-form label{display:block;font-size:.74rem;color:var(--muted);margin-bottom:.2rem;}
        .sk-input{padding:.4rem .55rem;border:1.5px solid #ddd;border-radius:6px;font-family:'Poppins',sans-serif;font-size:.85rem;}
        .sk-input:focus{border-color:var(--primary);outline:none;}
        .sk-nomor{width:230px;}
        .sk-tanggal{width:165px;}
        .btn-print{background:#27ae60;color:white;border:none;padding:.45rem .9rem;border-radius:8px;font-size:.8rem;cursor:pointer;text-decoration:none;white-space:nowrap;display:inline-block;}
        .btn-print:hover{background:#1e8449;color:white;}
        .btn-print.disabled{background:#c9ced3;cursor:not-allowed;pointer-events:none;}
        .btn-lihat{background:var(--light);color:var(--dark);border:none;padding:.45rem .8rem;border-radius:8px;font-size:.8rem;cursor:pointer;font-family:'Poppins',sans-serif;}
        .pill{display:inline-block;padding:.2rem .6rem;border-radius:20px;font-size:.72rem;font-weight:600;white-space:nowrap;}
        .pill-wait{background:#fff4e0;color:#e67e22;}
        .pill-ok{background:#e6f6ec;color:#1e8449;}
        .detail{display:none;margin-top:1rem;}
        .detail table{width:100%;border-collapse:collapse;}
        .detail th,.detail td{border:1px solid #eee;padding:.4rem .6rem;font-size:.8rem;text-align:left;}
        .detail th{background:var(--light);color:var(--dark);font-weight:600;}
</style>
</head>
<body>
@include('dekan.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">SK Yudisium</span>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="avatar">{{ substr($dekan->nama ?? 'D', 0, 1) }}</div>
            <div><div class="uname">{{ $dekan->nama ?? '-' }}</div><div class="urole">Dekan</div></div>
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

        <div class="stat-row" style="grid-template-columns:repeat(2,1fr);">
            <div class="stat-card"><div class="num" style="color:#e67e22;">{{ $jumlahMenunggu }}</div><div class="lbl">Pengajuan menunggu nomor SK</div></div>
            <div class="stat-card"><div class="num" style="color:#1e8449;">{{ $jumlahTerbit }}</div><div class="lbl">SK Yudisium sudah terbit</div></div>
        </div>

        <div class="table-card" style="margin-bottom:1.25rem;">
            <strong style="font-size:1rem;">SK Yudisium Mahasiswa</strong>
            <p style="color:var(--muted);font-size:.83rem;margin:0;">
                Kaprodi mengajukan daftar mahasiswa yang lulus sidang beserta IPK-nya. Isi nomor dan tanggal SK, simpan,
                lalu cetak. Setelah disimpan, SK lengkap dengan lampiran nama otomatis bisa diunduh kaprodi prodi bersangkutan.
            </p>
        </div>

        @forelse($daftar as $sk)
        @php
            $terbit = $sk->sudahTerbit();
            $milikForm = old('_sk') == $sk->id;
        @endphp
        <div class="yud-card {{ $terbit ? 'terbit' : 'menunggu' }}">
            <div class="yud-head">
                <div>
                    <strong style="font-size:1rem;">Program Studi {{ optional($sk->prodi)->nama_prodi ?? '-' }}</strong>
                    <div style="color:var(--muted);font-size:.82rem;">
                        {{ $sk->anggota_count }} mahasiswa &middot; diajukan kaprodi {{ optional($sk->diajukan_at)->translatedFormat('d F Y, H:i') ?? '-' }}
                        @if($terbit) &middot; {{ $sk->labelSemester() }} @endif
                    </div>
                </div>
                @if($terbit)
                    <span class="pill pill-ok"><i class="fas fa-check"></i> Terbit</span>
                @else
                    <span class="pill pill-wait"><i class="fas fa-clock"></i> Menunggu nomor SK</span>
                @endif
            </div>

            <form action="{{ route('dekan.sk-yudisium.simpan', $sk->id) }}" method="POST" class="yud-form">
                @csrf
                <input type="hidden" name="_sk" value="{{ $sk->id }}">
                <div>
                    <label>Nomor SK</label>
                    <input type="text" name="nomor_sk" class="sk-input sk-nomor" maxlength="100" placeholder="03/FT.01J/VIII/2026"
                           value="{{ $milikForm ? old('nomor_sk') : $sk->nomor_sk }}" required>
                </div>
                <div>
                    <label>Tanggal SK</label>
                    <input type="date" name="tanggal_sk" class="sk-input sk-tanggal"
                           value="{{ $milikForm ? old('tanggal_sk') : optional($sk->tanggal_sk)->format('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan</button>
                @if($terbit)
                    <a href="{{ route('dekan.sk-yudisium.cetak', $sk->id) }}" class="btn-print"><i class="fas fa-file-word"></i> Cetak</a>
                @else
                    <span class="btn-print disabled" title="Isi nomor & tanggal SK dulu"><i class="fas fa-file-word"></i> Cetak</span>
                @endif
                <button type="button" class="btn-lihat" data-target="detail-{{ $sk->id }}"><i class="fas fa-list"></i> Daftar mahasiswa</button>
            </form>

            <div class="detail" id="detail-{{ $sk->id }}">
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>No</th><th>Nama</th><th>NIM</th><th>Tempat, Tanggal Lahir</th><th>Tgl. Sidang</th><th>IPK</th></tr></thead>
                        <tbody>
                            @foreach($sk->anggota->sortBy(fn ($a) => mb_strtolower(optional(optional($a->sidang)->mahasiswa)->nama ?? ''))->values() as $n => $a)
                            <tr>
                                <td>{{ $n + 1 }}</td>
                                <td>{{ optional(optional($a->sidang)->mahasiswa)->nama ?? '-' }}</td>
                                <td>{{ optional(optional($a->sidang)->mahasiswa)->nim ?? '-' }}</td>
                                <td>{{ $a->tempatTanggalLahir() }}</td>
                                <td>{{ optional($a->sidang)->tanggal_sidang ? \Carbon\Carbon::parse($a->sidang->tanggal_sidang)->format('d/m/Y') : '-' }}</td>
                                <td>{{ number_format((float) $a->ipk, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @empty
        <div class="table-card"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada pengajuan SK Yudisium dari kaprodi.</p></div></div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.querySelectorAll('.btn-lihat').forEach(b => b.addEventListener('click', () => {
        const d = document.getElementById(b.dataset.target);
        d.style.display = d.style.display === 'block' ? 'none' : 'block';
    }));
</script>
</body>
</html>