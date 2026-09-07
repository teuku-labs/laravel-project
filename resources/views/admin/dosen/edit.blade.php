@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="page-title">
        <i class="fas fa-user-edit"></i>
        <span>Edit Data Dosen</span>
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

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start;">

    {{-- Form Edit --}}
    <div class="table-card">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.75rem;padding-bottom:1rem;border-bottom:2px solid var(--light-green);">
            <div style="width:55px;height:55px;background:var(--light-green);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--dark-green);font-size:1.5rem;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h5 style="font-weight:700;margin:0;">Edit Data Dosen</h5>
                <p style="color:var(--text-muted);font-size:.85rem;margin:0;">Perbarui informasi dosen di bawah ini</p>
            </div>
        </div>

        <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                <div>
                    <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $dosen->nama) }}"
                        class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="form-label">NUPTK <span style="color:red">*</span></label>
                    <input type="text" name="nuptk" value="{{ old('nuptk', $dosen->nuptk) }}"
                        class="form-control @error('nuptk') is-invalid @enderror" maxlength="16" required>
                    @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="form-label">Email</label>
                    <input type="email" value="{{ $dosen->user->email ?? '-' }}"
                        class="form-control" disabled style="background:#f8f9fa;">
                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.3rem;">
                        <i class="fas fa-lock"></i> Email tidak dapat diubah dari sini.
                    </div>
                </div>

                <div>
                    <label class="form-label">Program Studi <span style="color:red">*</span></label>
                    <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}"
                                {{ old('prodi_id', $dosen->prodi_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_prodi ?? $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;gap:1rem;margin-top:.5rem;">
                    <button type="submit" class="btn btn-primary-custom" style="flex:1;padding:.85rem;">
                        <i class="fas fa-save"></i> Perbarui Data
                    </button>
                    <a href="{{ route('admin.dosen.index') }}"
                        style="flex:1;padding:.85rem;background:#eee;color:#333;border-radius:10px;text-decoration:none;text-align:center;font-weight:500;">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Info Card Dosen --}}
    <div class="table-card">
        <div style="text-align:center;margin-bottom:1.25rem;">
            <div style="width:75px;height:75px;background:linear-gradient(135deg,var(--primary-green),var(--dark-green));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;font-weight:700;margin:0 auto .75rem;">
                {{ substr($dosen->nama, 0, 1) }}
            </div>
            <div style="font-weight:600;font-size:1rem;">{{ $dosen->nama }}</div>
            <div style="font-size:.82rem;color:var(--text-muted);">{{ $dosen->prodi->nama_prodi ?? $dosen->prodi->nama_prodi ?? '-' }}</div>
        </div>
        <div style="font-size:.85rem;">
            <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid #eee;">
                <span style="color:var(--text-muted);">Mahasiswa</span>
                <strong>{{ $dosen->mahasiswaPembimbing1->count() + $dosen->mahasiswaPembimbing2->count() }} orang</strong>
            </div>
            <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid #eee;">
                <span style="color:var(--text-muted);">Terdaftar</span>
                <strong>{{ \Carbon\Carbon::parse($dosen->created_at)->format('d M Y') }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;padding:.6rem 0;">
                <span style="color:var(--text-muted);">NUPTK</span>
                <code style="font-size:.78rem;">{{ $dosen->nuptk }}</code>
            </div>
        </div>
        <a href="{{ route('admin.dosen.show', $dosen->id) }}"
            style="display:block;text-align:center;margin-top:1rem;padding:.65rem;background:var(--light-green);color:var(--dark-green);border-radius:10px;text-decoration:none;font-weight:500;font-size:.88rem;">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
    </div>

</div>

@endsection