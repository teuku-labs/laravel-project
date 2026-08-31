<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SK Pembimbing - Kaprodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{--primary:#6c5ce7;--dark:#5a4bd1;--light:#f0eeff;--bg:#f8f9fa;--text:#2c3e50;--muted:#6c757d;--sidebar:280px;}
        *{margin:0;padding:0;box-sizing:border-box;}body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);}
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar);height:100vh;background:linear-gradient(180deg,var(--dark),var(--primary));z-index:1000;overflow-y:auto;}
        .sidebar-header{padding:1.5rem;border-bottom:1px solid rgba(255,255,255,0.1);}
        .sidebar-brand{font-size:1.2rem;font-weight:700;color:white;text-decoration:none;display:flex;align-items:center;gap:.75rem;}
        .sidebar-menu{padding:1rem 0;}.menu-cat{padding:.75rem 1.5rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;}
        .menu-item{display:flex;align-items:center;padding:.85rem 1.5rem;color:rgba(255,255,255,.9);text-decoration:none;transition:all .3s;border-left:3px solid transparent;}
        .menu-item:hover,.menu-item.active{background:rgba(255,255,255,.1);color:white;border-left-color:white;}
        .menu-item i{width:22px;margin-right:.75rem;}
        .main{margin-left:var(--sidebar);min-height:100vh;}
        .topbar{background:white;box-shadow:0 2px 15px rgba(0,0,0,.05);padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999;}
        .toggle-btn{background:none;border:none;font-size:1.3rem;color:var(--text);cursor:pointer;}
        .avatar{width:40px;height:40px;background:linear-gradient(135deg,var(--primary),var(--dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;}
        .content{padding:2rem;}
        .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
        .card-box{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);}
        .card-box h5{font-weight:600;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--light);color:var(--primary);}
        .info-row{display:flex;margin-bottom:.85rem;gap:.75rem;}
        .info-label{font-size:.82rem;color:var(--muted);min-width:140px;flex-shrink:0;}
        .info-value{font-size:.88rem;font-weight:500;}
        .btn-approve{background:linear-gradient(135deg,#27ae60,#1e8449);border:none;color:white;padding:.75rem 1.5rem;border-radius:10px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:.5rem;}
        .btn-approve:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(39,174,96,.4);}
        .btn-reject{background:linear-gradient(135deg,#e74c3c,#c0392b);border:none;color:white;padding:.75rem 1.5rem;border-radius:10px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;transition:all .3s;display:inline-flex;align-items:center;gap:.5rem;}
        .btn-reject:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(231,76,60,.4);}
        .form-control,.form-select{border-radius:10px;border:2px solid #eee;padding:.65rem 1rem;font-family:'Poppins',sans-serif;font-size:.88rem;}
        .form-control:focus,.form-select:focus{border-color:var(--primary);box-shadow:none;}
        .badge-approved{background:rgba(39,174,96,.15);color:#1e8449;padding:.4rem 1rem;border-radius:20px;font-size:.83rem;font-weight:500;}
        .badge-rejected{background:rgba(231,76,60,.15);color:#c0392b;padding:.4rem 1rem;border-radius:20px;font-size:.83rem;font-weight:500;}
        .badge-pending{background:rgba(243,156,18,.15);color:#d68910;padding:.4rem 1rem;border-radius:20px;font-size:.83rem;font-weight:500;}
        .btn-back{color:var(--primary);text-decoration:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1.25rem;}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}.detail-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="color:var(--muted);font-size:.9rem;">Detail SK Pembimbing</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar">{{ substr($kaprodi->nama ?? 'K', 0, 1) }}</div><div><div style="font-weight:600;font-size:.9rem;">{{ $kaprodi->nama }}</div><div style="font-size:.75rem;color:var(--muted);">Kaprodi</div></div></div>
    </nav>

    <div class="content">
        <a href="{{ route('kaprodi.sk-pembimbing.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>

        @if(session('success'))<div class="alert alert-success alert-dismissible fade show mb-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show mb-3"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if($errors->any())<div class="alert alert-danger alert-dismissible fade show mb-3">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        <div class="detail-grid">
            {{-- Data Mahasiswa --}}
            <div class="card-box">
                <h5><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
                <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $pengajuan->mahasiswa->nama ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $pengajuan->mahasiswa->nim ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Program Studi</span><span class="info-value">{{ $pengajuan->mahasiswa->prodi->nama ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Pembimbing 1</span><span class="info-value">{{ $pengajuan->pembimbing1->nama ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Pembimbing 2</span><span class="info-value">{{ $pengajuan->pembimbing2->nama ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Nomor SK</span><span class="info-value"><code>{{ $pengajuan->nomor_sk ?? 'Belum ada nomor' }}</code></span></div>
                <div class="info-row"><span class="info-label">Tanggal Pengajuan</span><span class="info-value">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y') }}</span></div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($pengajuan->kaprodi_approved)
                            <span class="badge-approved"><i class="fas fa-check"></i> Disetujui Kaprodi</span>
                        @elseif($pengajuan->kaprodi_rejected)
                            <span class="badge-rejected"><i class="fas fa-times"></i> Ditolak Kaprodi</span>
                        @else
                            <span class="badge-pending"><i class="fas fa-clock"></i> Menunggu Keputusan</span>
                        @endif
                    </span>
                </div>
                @if($pengajuan->catatan_kaprodi)
                <div class="info-row">
                    <span class="info-label">Catatan</span>
                    <span class="info-value" style="color:#c0392b;">{{ $pengajuan->catatan_kaprodi }}</span>
                </div>
                @endif
            </div>

            {{-- Aksi Kaprodi --}}
            <div class="card-box">
                <h5><i class="fas fa-gavel"></i> Keputusan Kaprodi</h5>

                @if($pengajuan->kaprodi_approved)
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> SK ini sudah <strong>disetujui</strong>.</div>
                @elseif($pengajuan->kaprodi_rejected)
                    <div class="alert alert-danger"><i class="fas fa-times-circle"></i> SK ini sudah <strong>ditolak</strong>.<br>Alasan: {{ $pengajuan->catatan_kaprodi }}</div>
                    {{-- Bisa approve ulang jika sebelumnya ditolak --}}
                    <form action="{{ route('kaprodi.sk-pembimbing.approve', $pengajuan->id) }}" method="POST" style="margin-top:1rem;">
                        @csrf
                        <button type="submit" class="btn-approve" onclick="return confirm('Setujui pengajuan SK ini?')">
                            <i class="fas fa-check"></i> Setujui Sekarang
                        </button>
                    </form>
                @else
                    <p style="color:var(--muted);font-size:.88rem;margin-bottom:1.5rem;">Tinjau data mahasiswa di sebelah kiri, lalu pilih keputusan di bawah ini.</p>

                    {{-- APPROVE --}}
                    <form action="{{ route('kaprodi.sk-pembimbing.approve', $pengajuan->id) }}" method="POST" style="margin-bottom:1rem;">
                        @csrf
                        <button type="submit" class="btn-approve" style="width:100%;justify-content:center;" onclick="return confirm('Setujui pengajuan SK Pembimbing ini?')">
                            <i class="fas fa-check-circle"></i> Setujui SK Pembimbing
                        </button>
                    </form>

                    {{-- REJECT --}}
                    <div style="border:2px solid #eee;border-radius:12px;padding:1.25rem;">
                        <p style="font-weight:600;font-size:.9rem;margin-bottom:1rem;color:#c0392b;"><i class="fas fa-times-circle"></i> Tolak Pengajuan</p>
                        <form action="{{ route('kaprodi.sk-pembimbing.reject', $pengajuan->id) }}" method="POST">
                            @csrf
                            <div style="margin-bottom:1rem;">
                                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Alasan Penolakan <span style="color:red">*</span></label>
                                <textarea name="catatan_kaprodi" class="form-control" rows="3"
                                    placeholder="Jelaskan alasan penolakan..." required>{{ old('catatan_kaprodi') }}</textarea>
                            </div>
                            <button type="submit" class="btn-reject" style="width:100%;justify-content:center;" onclick="return confirm('Tolak pengajuan ini?')">
                                <i class="fas fa-times-circle"></i> Tolak SK Pembimbing
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));</script>
</body>
</html>