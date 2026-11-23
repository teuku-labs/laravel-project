<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sidang Skripsi - Kaprodi</title>
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
        .file-link{display:inline-flex;align-items:center;gap:.4rem;background:var(--light);color:var(--primary);padding:.4rem .9rem;border-radius:8px;text-decoration:none;font-size:.83rem;font-weight:500;transition:all .3s;}
        .file-link:hover{background:var(--primary);color:white;}
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
        .detail-grid{align-items:start;}
        .right-col{display:flex;flex-direction:column;gap:1.5rem;}
        .btn-jadwal{background:linear-gradient(135deg,var(--primary),var(--dark));border:none;color:white;padding:.75rem 1.5rem;border-radius:10px;font-weight:600;width:100%;font-family:'Poppins',sans-serif;cursor:pointer;transition:all .3s;margin-top:.5rem;}
        .btn-jadwal:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(108,92,231,.4);}
        .form-label{font-size:.85rem;font-weight:500;margin-bottom:.4rem;}
        .time-range{display:flex;align-items:flex-end;gap:.75rem;}
        .time-box{flex:1;}
        .time-box-label{display:block;font-size:.72rem;color:var(--muted);margin-bottom:.3rem;}
        .time-box-readonly{background:var(--light);color:var(--dark);font-weight:600;display:flex;align-items:center;}
        .time-arrow{color:var(--primary);font-size:.9rem;padding-bottom:.75rem;}
        .warn-text{color:#d68910;font-weight:500;}
        @media(max-width:576px){.time-range{flex-direction:column;align-items:stretch;}.time-arrow{display:none;}}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.show{transform:translateX(0)}.main{margin-left:0}.detail-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<?php echo $__env->make('kaprodi.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="main">
    <nav class="topbar">
        <div style="display:flex;align-items:center;gap:1rem;"><button class="toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button><span style="color:var(--muted);font-size:.9rem;">Detail Sidang Skripsi</span></div>
        <div style="display:flex;align-items:center;gap:.75rem;"><div class="avatar"><?php echo e(substr($kaprodi->nama ?? 'K', 0, 1)); ?></div><div><div style="font-weight:600;font-size:.9rem;"><?php echo e($kaprodi->nama); ?></div><div style="font-size:.75rem;color:var(--muted);">Kaprodi</div></div></div>
    </nav>

    <div class="content">
        <a href="<?php echo e(route('kaprodi.sidang.index')); ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>

        <?php if(session('success')): ?><div class="alert alert-success alert-dismissible fade show mb-3"><i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if(session('error')): ?><div class="alert alert-danger alert-dismissible fade show mb-3"><i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert alert-danger alert-dismissible fade show mb-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

        <div class="detail-grid">
            
            <div class="card-box">
                <h5><i class="fas fa-user-graduate"></i> Data Mahasiswa</h5>
                <div class="info-row"><span class="info-label">Nama</span><span class="info-value"><?php echo e($sidang->mahasiswa->nama ?? '-'); ?></span></div>
                <div class="info-row"><span class="info-label">NIM</span><span class="info-value"><?php echo e($sidang->mahasiswa->nim ?? '-'); ?></span></div>
                <div class="info-row"><span class="info-label">Program Studi</span><span class="info-value"><?php echo e($sidang->mahasiswa->prodi->nama_prodi ?? '-'); ?></span></div>
                <div class="info-row"><span class="info-label">Pembimbing</span><span class="info-value"><?php echo e($sidang->pembimbing->nama ?? '-'); ?></span></div>

                <h5 style="margin-top:1.75rem;"><i class="fas fa-gavel"></i> Data Sidang</h5>
                <div class="info-row"><span class="info-label">Judul Skripsi</span><span class="info-value"><?php echo e($sidang->judul_skripsi ?? '-'); ?></span></div>
                <div class="info-row"><span class="info-label">Tanggal Sidang</span><span class="info-value"><?php echo e($sidang->tanggal_sidang ? \Carbon\Carbon::parse($sidang->tanggal_sidang)->format('d M Y') : 'Belum dijadwalkan'); ?></span></div>
                <div class="info-row"><span class="info-label">Tanggal Pengajuan</span><span class="info-value"><?php echo e(\Carbon\Carbon::parse($sidang->created_at)->format('d M Y')); ?></span></div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <?php if($sidang->kaprodi_approved): ?>
                            <span class="badge-approved"><i class="fas fa-check"></i> Disetujui Kaprodi</span>
                        <?php elseif($sidang->kaprodi_rejected): ?>
                            <span class="badge-rejected"><i class="fas fa-times"></i> Ditolak Kaprodi</span>
                        <?php else: ?>
                            <span class="badge-pending"><i class="fas fa-clock"></i> Menunggu Keputusan</span>
                        <?php endif; ?>
                    </span>
                </div>
                <?php if($sidang->catatan_kaprodi): ?>
                <div class="info-row">
                    <span class="info-label">Catatan</span>
                    <span class="info-value" style="color:#c0392b;"><?php echo e($sidang->catatan_kaprodi); ?></span>
                </div>
                <?php endif; ?>

                <h5 style="margin-top:1.75rem;"><i class="fas fa-paperclip"></i> Berkas Lampiran</h5>
                <div class="info-row">
                    <span class="info-label">Draft Skripsi</span>
                    <span class="info-value">
                        <?php if($sidang->file_draft): ?>
                            <a href="<?php echo e(asset('storage/'.$sidang->file_draft)); ?>" target="_blank" class="file-link"><i class="fas fa-file-alt"></i> Lihat File</a>
                        <?php else: ?>
                            <span style="color:var(--muted);">Belum diunggah</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Foto Pengesahan</span>
                    <span class="info-value">
                        <?php if($sidang->file_bebas_pustaka): ?>
                            <a href="<?php echo e(asset('storage/'.$sidang->file_bebas_pustaka)); ?>" target="_blank" class="file-link"><i class="fas fa-file-alt"></i> Lihat File</a>
                        <?php else: ?>
                            <span style="color:var(--muted);">Belum diunggah</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bukti Transfer</span>
                    <span class="info-value">
                        <?php if($sidang->bukti_transfer): ?>
                            <a href="<?php echo e(asset('storage/'.$sidang->bukti_transfer)); ?>" target="_blank" class="file-link"><i class="fas fa-receipt"></i> Lihat File</a>
                        <?php else: ?>
                            <span style="color:var(--muted);">Belum diunggah</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <div class="right-col">
            
            <div class="card-box">
                <h5><i class="fas fa-gavel"></i> Keputusan Kaprodi</h5>

                <?php if($sidang->kaprodi_approved): ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> Pengajuan sidang ini sudah <strong>disetujui</strong>.</div>
                <?php elseif($sidang->kaprodi_rejected): ?>
                    <div class="alert alert-danger"><i class="fas fa-times-circle"></i> Pengajuan sidang ini sudah <strong>ditolak</strong>.<br>Alasan: <?php echo e($sidang->catatan_kaprodi); ?></div>
                    
                    <form action="<?php echo e(route('kaprodi.sidang.approve', $sidang->id)); ?>" method="POST" style="margin-top:1rem;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-approve" onclick="return confirm('Setujui pengajuan sidang ini?')">
                            <i class="fas fa-check"></i> Setujui Sekarang
                        </button>
                    </form>
                <?php else: ?>
                    <p style="color:var(--muted);font-size:.88rem;margin-bottom:1.5rem;">Tinjau data dan berkas mahasiswa di sebelah kiri, lalu pilih keputusan di bawah ini.</p>

                    
                    <form action="<?php echo e(route('kaprodi.sidang.approve', $sidang->id)); ?>" method="POST" style="margin-bottom:1rem;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-approve" style="width:100%;justify-content:center;" onclick="return confirm('Setujui pengajuan Sidang Skripsi ini?')">
                            <i class="fas fa-check-circle"></i> Setujui Sidang Skripsi
                        </button>
                    </form>

                    
                    <div style="border:2px solid #eee;border-radius:12px;padding:1.25rem;">
                        <p style="font-weight:600;font-size:.9rem;margin-bottom:1rem;color:#c0392b;"><i class="fas fa-times-circle"></i> Tolak Pengajuan</p>
                        <form action="<?php echo e(route('kaprodi.sidang.reject', $sidang->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div style="margin-bottom:1rem;">
                                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Alasan Penolakan <span style="color:red">*</span></label>
                                <textarea name="catatan_kaprodi" class="form-control" rows="3"
                                    placeholder="Jelaskan alasan penolakan..." required><?php echo e(old('catatan_kaprodi')); ?></textarea>
                            </div>
                            <button type="submit" class="btn-reject" style="width:100%;justify-content:center;" onclick="return confirm('Tolak pengajuan sidang ini?')">
                                <i class="fas fa-times-circle"></i> Tolak Sidang Skripsi
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($sidang->kaprodi_approved): ?>
            
            <div class="card-box">
                <h5><i class="fas fa-user-tie"></i> Dosen Pembahas/Penguji</h5>
                <div class="info-row">
                    <span class="info-label">Pembahas/Penguji 1</span>
                    <span class="info-value">
                        <?php if($sidang->penguji1): ?>
                            <?php echo e($sidang->penguji1->nama); ?>

                        <?php else: ?>
                            <span class="warn-text"><i class="fas fa-exclamation-circle"></i> Belum ditentukan</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pembahas/Penguji 2</span>
                    <span class="info-value">
                        <?php if($sidang->penguji2): ?>
                            <?php echo e($sidang->penguji2->nama); ?>

                        <?php else: ?>
                            <span class="warn-text"><i class="fas fa-exclamation-circle"></i> Belum ditentukan</span>
                        <?php endif; ?>
                    </span>
                </div>
                <button type="button" class="btn-jadwal" style="width:auto;margin-top:.75rem;padding:.5rem 1.25rem;" data-bs-toggle="modal" data-bs-target="#editPengujiModal">
                    <i class="fas fa-pen"></i> <?php echo e(($sidang->penguji1_id && $sidang->penguji2_id) ? 'Ubah' : 'Tentukan'); ?> Dosen Pembahas/Penguji
                </button>
                <p style="font-size:.8rem;color:var(--muted);margin-top:.75rem;margin-bottom:0;">Dosen pembahas/penguji otomatis mengikuti pembahas seminar proposal mahasiswa ini. Hanya kaprodi yang dapat mengubahnya. Keduanya bertugas menguji saat sidang skripsi, terpisah dari dosen pembimbing.</p>
            </div>

            
            <div class="card-box">
                <h5><i class="fas fa-calendar-plus"></i> <?php echo e($jadwal ? 'Jadwal Sidang Skripsi' : 'Tetapkan Jadwal Sidang Skripsi'); ?></h5>

                <?php if($jadwal): ?>
                    <div class="info-row"><span class="info-label">Tanggal</span><span class="info-value"><?php echo e(\Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y')); ?></span></div>
                    <div class="info-row"><span class="info-label">Waktu</span><span class="info-value"><?php echo e($jadwal->waktu); ?><?php echo e($jadwal->waktu_selesai ? ' - '.$jadwal->waktu_selesai : ''); ?> WIB</span></div>
                    <div class="info-row"><span class="info-label">Ruang</span><span class="info-value"><?php echo e($jadwal->ruang); ?></span></div>
                    <button type="button" class="btn-jadwal" style="width:auto;margin-top:.25rem;padding:.5rem 1.25rem;" data-bs-toggle="collapse" data-bs-target="#formJadwal">
                        <i class="fas fa-pen"></i> Ubah Jadwal
                    </button>
                <?php endif; ?>

                <div id="formJadwal" class="<?php echo e($jadwal ? 'collapse' : ''); ?>" style="<?php echo e($jadwal ? 'margin-top:1rem;' : ''); ?>">
                    <form action="<?php echo e(route('kaprodi.sidang.jadwal', $sidang->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Sidang <span style="color:red">*</span></label>
                            <input type="date" name="tanggal_sidang" class="form-control" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" value="<?php echo e(old('tanggal_sidang')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu <span style="color:red">*</span></label>
                            <div class="time-range">
                                <div class="time-box">
                                    <span class="time-box-label">Mulai</span>
                                    <input type="time" name="waktu" id="waktuMulai" class="form-control" value="<?php echo e(old('waktu')); ?>" required oninput="hitungWaktuSelesai()">
                                </div>
                                <div class="time-arrow"><i class="fas fa-arrow-right"></i></div>
                                <div class="time-box">
                                    <span class="time-box-label">Selesai</span>
                                    <div class="form-control time-box-readonly" id="waktuSelesaiInfo">--:--</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Ruang <span style="color:red">*</span></label>
                            <select name="ruang" class="form-control" required>
                                <option value="" disabled <?php echo e(old('ruang') ? '' : 'selected'); ?>>Pilih ruang</option>
                                <?php $__currentLoopData = ['Seminar Lab. Kom. 1', 'Seminar Lab. Kom. 2', 'Seminar Lab. Mesin', 'Seminar Fakultas Teknik']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($r); ?>" <?php echo e(old('ruang') == $r ? 'selected' : ''); ?>><?php echo e($r); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-jadwal"><i class="fas fa-calendar-check"></i> <?php echo e($jadwal ? 'Simpan Perubahan Jadwal' : 'Tetapkan Jadwal'); ?></button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if($sidang->kaprodi_approved): ?>

<div class="modal fade" id="editPengujiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <form action="<?php echo e(route('kaprodi.sidang.penguji', $sidang->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header" style="border-bottom:2px solid var(--light);">
                    <h5 class="modal-title" style="color:var(--primary);font-weight:600;"><i class="fas fa-user-tie"></i> Tentukan Dosen Pembahas/Penguji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pembahas/Penguji 1 <span style="color:red">*</span></label>
                        <select name="penguji1_id" class="form-control" required>
                            <option value="" disabled <?php echo e(!$sidang->penguji1_id ? 'selected' : ''); ?>>Pilih dosen</option>
                            <?php $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d->id); ?>" <?php echo e($sidang->penguji1_id == $d->id ? 'selected' : ''); ?>><?php echo e($d->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pembahas/Penguji 2 <span style="color:red">*</span></label>
                        <select name="penguji2_id" class="form-control" required>
                            <option value="" disabled <?php echo e(!$sidang->penguji2_id ? 'selected' : ''); ?>>Pilih dosen</option>
                            <?php $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d->id); ?>" <?php echo e($sidang->penguji2_id == $d->id ? 'selected' : ''); ?>><?php echo e($d->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <small style="color:var(--muted);">Harus dua dosen berbeda dan tidak boleh sama dengan dosen pembimbing.</small>
                </div>
                <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-jadwal" style="width:auto;margin-top:0;padding:.6rem 1.5rem;"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.getElementById('sidebarToggle').addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));</script>
<script>
    function hitungWaktuSelesai(){
        const input = document.getElementById('waktuMulai');
        const info = document.getElementById('waktuSelesaiInfo');
        if(!input || !info) return;
        if(!input.value){ info.textContent = '--:--'; return; }
        const [jam, menit] = input.value.split(':').map(Number);
        const mulai = new Date();
        mulai.setHours(jam, menit, 0, 0);
        mulai.setMinutes(mulai.getMinutes() + 90); // +1 jam 30 menit
        info.textContent = String(mulai.getHours()).padStart(2,'0') + ':' + String(mulai.getMinutes()).padStart(2,'0');
    }
    hitungWaktuSelesai();
</script>
</body>
</html><?php /**PATH C:\laragon\www\seminar-apk\resources\views/kaprodi/sidang/show.blade.php ENDPATH**/ ?>