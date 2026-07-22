@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-title">
        <i class="fas fa-user-plus"></i>
        <span>Tambah Dosen Baru</span>
    </div>
    <a href="{{ route('admin.dosen.index') }}" class="btn" style="background:#eee;color:#333;padding:.65rem 1.25rem;border-radius:10px;text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-3">
    @foreach($errors->all() as $e)
        <div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card" style="max-width:650px;">
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.75rem;padding-bottom:1rem;border-bottom:2px solid var(--light-green);">
        <div style="width:55px;height:55px;background:var(--light-green);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--dark-green);font-size:1.5rem;">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <h5 style="font-weight:700;margin:0;">Data Dosen</h5>
            <p style="color:var(--text-muted);font-size:.85rem;margin:0;">Isi semua kolom yang bertanda bintang (*)</p>
        </div>
    </div>

    <form action="{{ route('admin.dosen.store') }}" method="POST">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            <div>
                <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Contoh: Dr. Ahmad Fauzi, M.Kom" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label">NUPTK <span style="color:red">*</span></label>
                <input type="text" name="nuptk" value="{{ old('nuptk') }}"
                    class="form-control @error('nuptk') is-invalid @enderror"
                    placeholder="Contoh: 1234567890123456" maxlength="16" required>
                @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:.3rem;">
                    <i class="fas fa-info-circle"></i> NUPTK akan digunakan sebagai username login dosen.
                </div>
            </div>

            <div>
                <label class="form-label">Email <span style="color:red">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Contoh: ahmad.fauzi@univ.ac.id" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="form-label">Program Studi <span style="color:red">*</span></label>
                <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach($prodis as $p)
                        <option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_prodi ?? $p->nama }}
                        </option>
                    @endforeach
                </select>
                @error('prodi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Info password default --}}
            <div style="background:linear-gradient(135deg,#e8f8f0,#d5f5e3);border-radius:12px;padding:1rem;border-left:4px solid var(--primary-green);">
                <div style="font-weight:600;color:var(--dark-green);margin-bottom:.25rem;">
                    <i class="fas fa-key"></i> Informasi Akun Login
                </div>
                <p style="font-size:.85rem;color:var(--text-dark);margin:0;">
                    Password default dosen: <strong>password123</strong><br>
                    Login menggunakan NUPTK yang diisi di atas.
                </p>
            </div>

            <div style="display:flex;gap:1rem;margin-top:.5rem;">
                <button type="submit" class="btn btn-primary-custom" style="flex:1;padding:.85rem;">
                    <i class="fas fa-save"></i> Simpan Dosen
                </button>
                <a href="{{ route('admin.dosen.index') }}"
                    style="flex:1;padding:.85rem;background:#eee;color:#333;border-radius:10px;text-decoration:none;text-align:center;font-weight:500;">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

@endsection