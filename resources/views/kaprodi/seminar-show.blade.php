<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Seminar LKP - Kaprodi</title>
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
        .content{padding:2rem;}
        .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
        .card-box{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 5px 20px rgba(0,0,0,.05);}
        .card-box h5{font-weight:600;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--light);color:var(--primary);}
        .info-row{display:flex;margin-bottom:.85rem;gap:.75rem;}
        .info-label{font-size:.82rem;color:var(--muted);min-width:140px;flex-shrink:0;}
        .info-value{font-size:.88rem;font-weight:500;}
        .form-label{font-size:.85rem;font-weight:500;margin-bottom:.4rem;}
        .form-control,.form-select{border-radius:10px;border:2px solid #eee;padding:.65rem 1rem;font-family:'Poppins',sans-serif;font-size:.88rem;}
        .form-control:focus,.form-select:focus{border-color:var(--primary);box-shadow:none;}
        .btn-jadwal{background:linear-gradient(135deg,var(--primary),var(--dark));border:none;color:white;padding:.75rem 1.5rem;border-radius:10px;font-weight:600;width:100%;font-family:'Poppins',sans-serif;cursor:pointer;transition:all .3s;margin-top:.5rem;}
        .btn-jadwal:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(108,92,231,.4);}
        .btn-back{color:var(--primary);text-decoration:none;font-size:.88rem;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1.25rem;}
        .btn-back:hover{color:var(--dark);}
        .badge-done{background:rgba(39,174,96,.15);color:#1e8449;padding:.3rem .8rem;border-radius:20px;font-size:.8rem;}
        .file-link{display:inline-flex;align-items:center;gap:.4rem;color:var(--primary);text-decoration:none;font-size:.85rem;font-weight:500;}
        .file-link:hover{color:var(--dark);}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}.detail-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
@include('kaprodi.partials.sidebar')

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;">
            <button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span style="color:var(--muted);font-size:.9rem;">Detail Seminar LKP</span>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="avatar">{{ substr($kaprodi->nama ?? 'K', 0, 1) }}</div>
            <div><div style="font-weight:600;font-size:.9rem;">{{ $kaprodi->nama ?? '-' }}</div><div style="font-size:.75rem;color:var(--muted);">Kaprodi</div></div>
        </div>
    </nav>

    <div class="content">
        <a href="{{ route('kaprodi.seminar') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="detail-grid">
            {{-- Detail Mahasiswa --}}
            <div class="card-box">
                <h5><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
                <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $seminar->mahasiswa->nama ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">NIM</span><span class="info-value">{{ $seminar->mahasiswa->nim ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $seminar->email }}</span></div>
                <div class="info-row"><span class="info-label">No HP</span><span class="info-value">{{ $seminar->no_hp }}</span></div>
                <div class="info-row"><span class="info-label">NIK KTP</span><span class="info-value">{{ $seminar->nik_ktp }}</span></div>
                <div class="info-row"><span class="info-label">Tempat Lahir</span><span class="info-value">{{ $seminar->tempat_lahir }}</span></div>
                <div class="info-row"><span class="info-label">Tanggal Lahir</span><span class="info-value">{{ \Carbon\Carbon::parse($seminar->tanggal_lahir)->format('d M Y') }}</span></div>
            </div>

            {{-- Detail Seminar --}}
            <div class="card-box">
                <h5><i class="fas fa-file-alt"></i> Data Seminar LKP</h5>
                <div class="info-row"><span class="info-label">Judul LKP</span><span class="info-value">{{ $seminar->judul_lkp }}</span></div>
                <div class="info-row">
                    <span class="info-label">Dosen Pembimbing</span>
                    <span class="info-value" style="display:flex;align-items:center;gap:.6rem;">
                        {{ $seminar->dosen->nama ?? '-' }}
                        <button type="button" class="btn btn-sm" style="color:var(--primary);padding:0;border:none;background:none;" data-bs-toggle="modal" data-bs-target="#editPembimbingModal" title="Edit Dosen Pembimbing">
                            <i class="fas fa-pen"></i>
                        </button>
                    </span>
                </div>
                <div class="info-row"><span class="info-label">Tanggal Daftar</span><span class="info-value">{{ \Carbon\Carbon::parse($seminar->created_at)->format('d M Y') }}</span></div>
                <div class="info-row">
                    <span class="info-label">Laporan LKP</span>
                    <span class="info-value"><a href="{{ asset('storage/'.$seminar->file_laporan) }}" target="_blank" class="file-link"><i class="fas fa-file-pdf"></i> Lihat Laporan</a></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bukti Transfer</span>
                    <span class="info-value"><a href="{{ asset('storage/'.$seminar->bukti_transfer) }}" target="_blank" class="file-link"><i class="fas fa-image"></i> Lihat Bukti</a></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($seminar->tanggal_seminar)
                            <span class="badge-done"><i class="fas fa-check"></i> Terjadwal {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('d M Y') }}</span>
                        @else
                            <span style="color:#d68910;font-weight:500;"><i class="fas fa-clock"></i> Menunggu Jadwal</span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Dosen Pembahas/Penguji --}}
            <div class="card-box" style="grid-column:1/-1;">
                <h5><i class="fas fa-user-tie"></i> Dosen Pembahas/Penguji</h5>
                <div class="info-row">
                    <span class="info-label">Pembahas/Penguji</span>
                    <span class="info-value" style="display:flex;align-items:center;gap:.6rem;">
                        @if($seminar->penguji)
                            {{ $seminar->penguji->nama }}
                        @else
                            <span style="color:#d68910;font-weight:500;"><i class="fas fa-exclamation-circle"></i> Belum ditentukan</span>
                        @endif
                        <button type="button" class="btn btn-sm" style="color:var(--primary);padding:0;border:none;background:none;" data-bs-toggle="modal" data-bs-target="#editPengujiModal" title="Tentukan Dosen Pembahas/Penguji">
                            <i class="fas fa-pen"></i>
                        </button>
                    </span>
                </div>
                <p style="font-size:.8rem;color:var(--muted);margin-top:.5rem;margin-bottom:0;">Dosen pembahas/penguji bertugas menguji mahasiswa saat pelaksanaan seminar LKP, terpisah dari dosen pembimbing.</p>
            </div>

            {{-- Form Set Jadwal --}}
            @if(!$seminar->tanggal_seminar)
            <div class="card-box" style="grid-column:1/-1;">
                <h5><i class="fas fa-calendar-plus"></i> Tetapkan Jadwal Seminar</h5>
                <form action="{{ route('kaprodi.seminar.jadwal', $seminar->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Seminar <span style="color:red">*</span></label>
                            <input type="date" name="tanggal_seminar" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu <span style="color:red">*</span></label>
                            <input type="time" name="waktu" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ruang <span style="color:red">*</span></label>
                            <select name="ruang" class="form-control" required>
                                <option value="" disabled selected>Pilih ruang</option>
                                <option value="Seminar Lab. Kom. 1">Seminar Lab. Kom. 1</option>
                                <option value="Seminar Lab. Kom. 2">Seminar Lab. Kom. 2</option>
                                <option value="Seminar Lab. Mesin">Seminar Lab. Mesin</option>
                                <option value="Seminar Fakultas Teknik">Seminar Fakultas Teknik</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-jadwal mt-3"><i class="fas fa-calendar-check"></i> Tetapkan Jadwal</button>
                </form>
            </div>
            @endif
        </div>
    </div>

    {{-- Modal: Edit Dosen Pembimbing LKP --}}
    <div class="modal fade" id="editPembimbingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:16px;border:none;">
                <form action="{{ route('kaprodi.seminar.pembimbing', $seminar->id) }}" method="POST">
                    @csrf
                    <div class="modal-header" style="border-bottom:2px solid var(--light);">
                        <h5 class="modal-title" style="color:var(--primary);font-weight:600;"><i class="fas fa-user-edit"></i> Edit Dosen Pembimbing LKP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Dosen Pembimbing <span style="color:red">*</span></label>
                        <select name="dosen_id" class="form-control" required>
                            <option value="" disabled {{ !$seminar->pembimbing1_id ? 'selected' : '' }}>Pilih dosen</option>
                            @foreach($dosenList as $d)
                                <option value="{{ $d->id }}" {{ $seminar->pembimbing1_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer" style="border-top:none;">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-jadwal" style="width:auto;margin-top:0;padding:.6rem 1.5rem;"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Tentukan Dosen Pembahas/Penguji --}}
    <div class="modal fade" id="editPengujiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:16px;border:none;">
                <form action="{{ route('kaprodi.seminar.penguji', $seminar->id) }}" method="POST">
                    @csrf
                    <div class="modal-header" style="border-bottom:2px solid var(--light);">
                        <h5 class="modal-title" style="color:var(--primary);font-weight:600;"><i class="fas fa-user-tie"></i> Tentukan Dosen Pembahas/Penguji</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Dosen Pembahas/Penguji <span style="color:red">*</span></label>
                        <select name="penguji_id" class="form-control" required>
                            <option value="" disabled {{ !$seminar->penguji_id ? 'selected' : '' }}>Pilih dosen</option>
                            @foreach($dosenList as $d)
                                <option value="{{ $d->id }}" {{ $seminar->penguji_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                            @endforeach
                        </select>
                        <small style="color:var(--muted);">Tidak boleh sama dengan dosen pembimbing.</small>
                    </div>
                    <div class="modal-footer" style="border-top:none;">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-jadwal" style="width:auto;margin-top:0;padding:.6rem 1.5rem;"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));</script>
</body>
</html>