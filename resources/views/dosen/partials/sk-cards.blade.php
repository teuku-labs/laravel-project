{{-- Daftar SK (Pembimbing + Pembahas) yang memuat dosen yang sedang login.
     Variabel: $skItems (lihat DosenController::skItemsUntuk). --}}
<div class="documents-grid">
    @forelse($skItems as $sk)
        <div class="document-card">
            <div class="document-icon"><i class="fas fa-file-word"></i></div>
            <div class="document-title">{{ $sk->jenis }}</div>
            <div class="document-info">
                <p><i class="fas fa-user-tag"></i> Peran Anda: <strong>{{ $sk->peran }}</strong></p>
                <p><i class="fas fa-user-graduate"></i> {{ $sk->mahasiswa }}</p>
                <p><i class="fas fa-id-card"></i> {{ $sk->nim }}</p>
                <p><i class="fas fa-hashtag"></i> {{ $sk->nomor_sk }}</p>
                <p><i class="fas fa-calendar"></i> {{ \App\Models\PengajuanSk::tanggalIndonesia($sk->tanggal) }}</p>
            </div>
            <a href="{{ $sk->url }}" class="btn-download">
                <i class="fas fa-download"></i> Unduh SK (Word)
            </a>
        </div>
    @empty
        <div style="grid-column:1/-1;">
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h5>Belum Ada SK</h5>
                <p>SK Pembimbing dan SK Pembahas yang memuat nama Anda akan muncul di sini setelah diterbitkan dekan.</p>
            </div>
        </div>
    @endforelse
</div>