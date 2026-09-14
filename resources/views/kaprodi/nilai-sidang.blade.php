<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Sidang Skripsi - Kaprodi</title>
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
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}}
    </style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">Nilai Sidang Skripsi</span>
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
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-card">
            <div class="table-header">
                <div>
                    <strong style="font-size:1rem;">Input &amp; Nilai Sidang Skripsi</strong>
                    <p style="color:var(--muted);font-size:.83rem;margin:0;">
                        Total: {{ $sidangList->count() }} mahasiswa &middot;
                        Anda hanya bisa mengisi nilai untuk sidang yang Anda menjadi pembimbing.
                    </p>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari mahasiswa...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="custom-table" id="nilaiTable">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Judul Skripsi</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">NIM</th>
                            <th colspan="4">Aspek Penilaian</th>
                            <th rowspan="2">Rata-rata</th>
                            <th rowspan="2">Nilai Huruf</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Isi Materi</th>
                            <th>Penyajian</th>
                            <th>Penguasaan Materi</th>
                            <th>Sikap Mental</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sidangList as $i => $sd)
                        @php
                            $nilai = $sd->nilai;
                            $berhak = $dosenSaya && ($sd->pembimbing_id == $dosenSaya->id);
                            $formId = 'form-nilai-' . $sd->id;
                        @endphp
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td class="text-start">{{ Str::limit($sd->judul_skripsi, 30) }}</td>
                            <td class="text-start"><strong>{{ $sd->mahasiswa->nama ?? '-' }}</strong></td>
                            <td>{{ $sd->mahasiswa->nim ?? '-' }}</td>
                            <td><input type="number" step="0.01" min="0" max="100" name="isi_materi" form="{{ $formId }}" class="nilai-input" value="{{ old('isi_materi', $nilai->isi_materi ?? '') }}" {{ $berhak ? '' : 'disabled' }} required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="penyajian" form="{{ $formId }}" class="nilai-input" value="{{ old('penyajian', $nilai->penyajian ?? '') }}" {{ $berhak ? '' : 'disabled' }} required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="penguasaan_materi" form="{{ $formId }}" class="nilai-input" value="{{ old('penguasaan_materi', $nilai->penguasaan_materi ?? '') }}" {{ $berhak ? '' : 'disabled' }} required></td>
                            <td><input type="number" step="0.01" min="0" max="100" name="sikap_mental" form="{{ $formId }}" class="nilai-input" value="{{ old('sikap_mental', $nilai->sikap_mental ?? '') }}" {{ $berhak ? '' : 'disabled' }} required></td>
                            <td class="rata-cell">{{ $nilai->rata_rata ?? '-' }}</td>
                            <td><span class="badge-huruf">{{ $nilai->nilai_huruf ?? '-' }}</span></td>
                            <td>
                                @if($berhak)
                                    <button type="submit" form="{{ $formId }}" class="btn-save"><i class="fas fa-save"></i> Simpan</button>
                                @else
                                    <span class="badge-locked"><i class="fas fa-lock"></i> Bukan pembimbing Anda</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada data sidang skripsi.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Form tersembunyi per baris (dirujuk via atribut form="..." pada input/tombol di tabel) --}}
        @foreach($sidangList as $sd)
            <form id="form-nilai-{{ $sd->id }}" action="{{ route('kaprodi.nilai-sidang.store', $sd->id) }}" method="POST" style="display:none;">
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
        document.querySelectorAll('#nilaiTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
</body>
</html>