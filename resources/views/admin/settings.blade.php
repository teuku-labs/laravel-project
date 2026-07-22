@extends('layouts.admin')
@section('content')
<div style="margin-bottom:2rem;">
    <h2 style="font-weight:700;">Pengaturan</h2>
    <p style="color:var(--text-muted);font-size:.9rem;">Kelola pengaturan akun Admin</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="table-card" style="max-width:500px;">
    <h5 style="font-weight:600;color:var(--dark-green);border-bottom:2px solid var(--light-green);padding-bottom:.75rem;margin-bottom:1.5rem;"><i class="fas fa-key"></i> Ubah Password</h5>
    <form action="{{ route('admin.settings.password') }}" method="POST">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Password Lama <span style="color:red">*</span></label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama" required>
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Password Baru <span style="color:red">*</span></label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label style="font-size:.85rem;font-weight:500;margin-bottom:.4rem;display:block;">Konfirmasi Password Baru <span style="color:red">*</span></label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" style="background:linear-gradient(135deg,var(--primary-green),var(--dark-green));color:white;border:none;padding:.85rem;border-radius:12px;font-weight:600;font-family:'Poppins',sans-serif;cursor:pointer;">
                <i class="fas fa-save"></i> Simpan Password Baru
            </button>
        </div>
    </form>
</div>
@endsection