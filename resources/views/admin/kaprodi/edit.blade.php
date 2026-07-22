@extends('layouts.admin')

@section('content')

<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.kaprodi.index') }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Edit Kaprodi</h2>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card" style="max-width:600px;">
    <form action="{{ route('admin.kaprodi.update', $kaprodi->id) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $kaprodi->nama) }}" class="form-control" required>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">NUPTK <span style="color:red">*</span></label>
                <input type="text" name="nuptk" value="{{ old('nuptk', $kaprodi->nuptk) }}" class="form-control" required>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Program Studi <span style="color:red">*</span></label>
                <select name="prodi_id" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $p)
                    <option value="{{ $p->id }}" {{ old('prodi_id', $kaprodi->prodi_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;border:none;padding:.85rem;border-radius:12px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>

@endsection