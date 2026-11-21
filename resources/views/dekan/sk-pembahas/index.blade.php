<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Pembahas - Dekan</title>
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
    </style>
</head>
<body>
@include('dekan.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">SK Pembahas</span>
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
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="stat-row">
            <div class="stat-card"><div class="num">{{ $totalSk }}</div><div class="lbl">Pembahas sudah ditetapkan</div></div>
            <div class="stat-card"><div class="num" style="color:#e67e22;">{{ $belumTerbit }}</div><div class="lbl">Menunggu nomor SK</div></div>
            <div class="stat-card"><div class="num" style="color:#1e8449;">{{ $sudahTerbit }}</div><div class="lbl">SK sudah terbit</div></div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div>
                    <strong style="font-size:1rem;">SK Penunjukan Dosen Pembahas Tugas Akhir</strong>
                    <p style="color:var(--muted);font-size:.83rem;margin:0;">
                        Daftar terisi otomatis dari proposal yang kedua pembahasnya sudah ditetapkan kaprodi.
                        Isi nomor dan tanggal SK, simpan, lalu cetak.
                    </p>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari mahasiswa / NIM...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="custom-table sk-table" id="skTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Prodi</th>
                            <th>TA. Semester</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul</th>
                            <th>Tempat/Tgl. Lahir</th>
                            <th>Pembahas Utama</th>
                            <th>Pembahas Pendamping</th>
                            <th>Nomor SK Tugas</th>
                            <th>Tanggal SK Tugas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposalList as $i => $p)
                        @php
                            $mhs   = $p->mahasiswa;
                            $judul = $p->judul;
                            $ttl   = $p->tempatTanggalLahir();
                            $lengkap = $judul && $ttl && $p->penguji1 && $p->penguji2;
                            $formId = 'form-sk-' . $p->id;
                        @endphp
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
                            <td>{{ $p->taSemester() }}</td>
                            <td>{{ $mhs->nim ?? '-' }}</td>
                            <td class="text-start"><strong>{{ $mhs->nama ?? '-' }}</strong></td>
                            <td class="text-start" style="min-width:220px;">
                                @if($judul) {{ $judul }}
                                @else <span class="warn"><i class="fas fa-exclamation-triangle"></i> Judul proposal kosong</span>
                                @endif
                            </td>
                            <td class="text-start">
                                @if($ttl) {{ $ttl }}
                                @else <span class="warn"><i class="fas fa-exclamation-triangle"></i> Belum daftar LKP</span>
                                @endif
                            </td>
                            <td class="text-start">{{ $p->penguji1->nama ?? '-' }}</td>
                            <td class="text-start">{{ $p->penguji2->nama ?? '-' }}</td>
                            <td><input type="text" name="nomor_sk" form="{{ $formId }}" class="sk-input sk-nomor" maxlength="100" placeholder="05/FTSI.02B/X/2025" value="{{ $p->nomor_sk_pembahas }}" required></td>
                            <td><input type="date" name="tanggal_sk" form="{{ $formId }}" class="sk-input sk-tanggal" value="{{ optional($p->tanggal_sk_pembahas)->format('Y-m-d') }}" required></td>
                            <td>
                                @if($p->sudahTerbitSkPembahas())
                                    <span class="pill pill-ok"><i class="fas fa-check"></i> Terbit</span>
                                @else
                                    <span class="pill pill-wait"><i class="fas fa-clock"></i> Menunggu</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;">
                                <button type="submit" form="{{ $formId }}" class="btn-save"><i class="fas fa-save"></i> Simpan</button>
                                @if($p->sudahTerbitSkPembahas() && $lengkap)
                                    <a href="{{ route('dekan.sk-pembahas.cetak', $p->id) }}" class="btn-print"><i class="fas fa-file-word"></i> Cetak</a>
                                @else
                                    <span class="btn-print disabled" title="{{ $p->sudahTerbitSkPembahas() ? 'Data mahasiswa belum lengkap' : 'Isi nomor & tanggal SK dulu' }}"><i class="fas fa-file-word"></i> Cetak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="13"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada proposal yang pembahasnya sudah ditetapkan kaprodi.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Form tersembunyi per baris (dirujuk lewat atribut form="..." pada input/tombol di tabel) --}}
        @foreach($proposalList as $p)
            <form id="form-sk-{{ $p->id }}" action="{{ route('dekan.sk-pembahas.simpan', $p->id) }}" method="POST" style="display:none;">
                @csrf
            </form>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#skTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
</body>
</html>