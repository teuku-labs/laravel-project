@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <a href="{{ route('admin.sk-pembimbing.show', $pengajuan->id) }}" style="color:var(--primary-green);text-decoration:none;font-size:.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="font-weight:700;margin-top:.5rem;">Edit Nomor SK Pembimbing</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">{{ $pengajuan->mahasiswa->nama ?? '-' }} ({{ $pengajuan->mahasiswa->nim ?? '-' }})</p>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle"></i> {{ $e }}</div>@endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card" style="max-width:600px;">
    <form action="{{ route('admin.sk-pembimbing.update', $pengajuan->id) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Pembimbing 1</label>
                <input type="text" value="{{ $pengajuan->pembimbing1->nama ?? '-' }}" class="form-control" disabled>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Pembimbing 2</label>
                <input type="text" value="{{ $pengajuan->pembimbing2->nama ?? '-' }}" class="form-control" disabled>
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Nomor SK</label>
                <input type="text" name="nomor_sk" value="{{ old('nomor_sk', $pengajuan->nomor_sk) }}" class="form-control" placeholder="Contoh: 123/SK-PEMBIMBING/2026">
                <small style="color:var(--text-muted);">Mengisi nomor SK juga akan menandai pengajuan ini terverifikasi.</small>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;border:none;padding:.85rem;border-radius:12px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection