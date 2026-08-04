@extends('layouts.admin')

@section('content')

<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.kaprodi.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Tambah Kaprodi</h2>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card" style="max-width:600px;">
    <form action="{{ route('admin.kaprodi.store') }}" method="POST">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">NUPTK <span style="color:red">*</span></label>
                <input type="text" name="nuptk" value="{{ old('nuptk') }}" class="form-control" placeholder="Masukkan NUPTK" required>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Email <span style="color:red">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Program Studi <span style="color:red">*</span></label>
                <select name="prodi_id" class="form-select" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="background:#f0eeff;border-radius:10px;padding:1rem;font-size:.85rem;color:#5a4bd1;">
                <i class="fas fa-info-circle"></i> Password default: <strong>password123</strong> (bisa diubah setelah login)
            </div>
            <button type="submit" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;border:none;padding:.85rem;border-radius:12px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">
                <i class="fas fa-save"></i> Simpan Kaprodi
            </button>
        </div>
    </form>
</div>

@endsection