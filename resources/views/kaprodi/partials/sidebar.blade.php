{{--
    Sidebar Kaprodi.
    Dikelompokkan menurut alur kerja:
      1. Kelola Prodi      -> hal yang harus diputuskan/dijadwalkan kaprodi sebagai kepala prodi
      2. Surat Keputusan   -> pengajuan SK ke Dekan
      3. Sebagai Dosen     -> peran kaprodi sebagai pembimbing/penguji
      4. Akun
    Angka badge ($sbBadge) & identitas ($sbKaprodi) disediakan view composer di AppServiceProvider,
    jadi otomatis muncul di semua halaman kaprodi tanpa mengubah controller.
--}}
@php
    $sb         = $sbBadge ?? [];
    $nilaiAktif = request()->routeIs('kaprodi.nilai-lkp.*', 'kaprodi.nilai-proposal.*', 'kaprodi.nilai-sidang.*');
@endphp
<style>
    .sidebar .sidebar-user{padding:.85rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.1);color:#fff;}
    .sidebar .sidebar-user strong{display:block;font-size:.88rem;line-height:1.3;}
    .sidebar .sidebar-user small{color:rgba(255,255,255,.65);font-size:.75rem;}
    .sidebar .sidebar-menu{padding:.5rem 0 1.5rem;}
    .sidebar .menu-cat{padding:1rem 1.5rem .35rem;}
    .sidebar .menu-item{padding-top:.7rem;padding-bottom:.7rem;}
    .sidebar .menu-count{margin-left:auto;min-width:20px;height:20px;padding:0 .45rem;border-radius:10px;background:#ff7675;color:#fff;font-size:.7rem;font-weight:600;display:inline-flex;align-items:center;justify-content:center;}
    .sidebar .menu-group>summary{list-style:none;cursor:pointer;}
    .sidebar .menu-group>summary::-webkit-details-marker{display:none;}
    .sidebar .menu-item i.chev{width:auto;margin:0 0 0 auto;font-size:.7rem;transition:transform .2s;}
    .sidebar .menu-group[open]>summary i.chev{transform:rotate(180deg);}
    .sidebar .menu-item.sub{padding:.55rem 1.5rem .55rem 3.4rem;font-size:.9rem;color:rgba(255,255,255,.8);}
    .sidebar .menu-logout{width:100%;text-align:left;background:none;border:0;border-left:3px solid transparent;color:rgba(255,255,255,.9);font:inherit;cursor:pointer;}
    .sidebar .menu-item:focus-visible{outline:2px solid #fff;outline-offset:-2px;}
</style>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-brand"><i class="fas fa-user-tie"></i><span>Kaprodi Panel</span></a>
    </div>
    @if(!empty($sbKaprodi))
        <div class="sidebar-user">
            <strong>{{ $sbKaprodi['nama'] }}</strong>
            @if(!empty($sbKaprodi['prodi']))<small>{{ $sbKaprodi['prodi'] }}</small>@endif
        </div>
    @endif
    <nav class="sidebar-menu">
        <a href="{{ route('kaprodi.dashboard') }}" class="menu-item {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>Dashboard</a>

        <div class="menu-cat">Kelola Prodi</div>
        <a href="{{ route('kaprodi.seminar') }}" class="menu-item {{ request()->routeIs('kaprodi.seminar', 'kaprodi.seminar.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>Seminar LKP
            @if(($sb['seminar'] ?? 0) > 0)<span class="menu-count" title="Belum dijadwalkan">{{ $sb['seminar'] }}</span>@endif
        </a>
        <a href="{{ route('kaprodi.proposal.index') }}" class="menu-item {{ request()->routeIs('kaprodi.proposal.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>Seminar Proposal
            @if(($sb['proposal'] ?? 0) > 0)<span class="menu-count" title="Belum dijadwalkan">{{ $sb['proposal'] }}</span>@endif
        </a>
        <a href="{{ route('kaprodi.sidang.index') }}" class="menu-item {{ request()->routeIs('kaprodi.sidang.*') ? 'active' : '' }}">
            <i class="fas fa-gavel"></i>Sidang Skripsi
            @if(($sb['sidang'] ?? 0) > 0)<span class="menu-count" title="Menunggu keputusan Anda">{{ $sb['sidang'] }}</span>@endif
        </a>

        <div class="menu-cat">Surat Keputusan</div>
        <a href="{{ route('kaprodi.sk-dekan.index') }}" class="menu-item {{ request()->routeIs('kaprodi.sk-dekan.*') ? 'active' : '' }}"><i class="fas fa-paper-plane"></i>Ajukan SK ke Dekan</a>
        <a href="{{ route('kaprodi.yudisium.index') }}" class="menu-item {{ request()->routeIs('kaprodi.yudisium.*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i>Yudisium</a>
        <a href="{{ route('kaprodi.sk-yudisium.index') }}" class="menu-item {{ request()->routeIs('kaprodi.sk-yudisium.*') ? 'active' : '' }}"><i class="fas fa-file-signature"></i>SK Yudisium</a>

        <div class="menu-cat">Sebagai Dosen</div>
        <a href="{{ route('kaprodi.bimbingan.index') }}" class="menu-item {{ request()->routeIs('kaprodi.bimbingan.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher"></i>Bimbingan
            @if(($sb['bimbingan'] ?? 0) > 0)<span class="menu-count" title="Pengajuan bimbingan menunggu">{{ $sb['bimbingan'] }}</span>@endif
        </a>
        <a href="{{ route('kaprodi.jadwal-saya') }}" class="menu-item {{ request()->routeIs('kaprodi.jadwal-saya') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Jadwal Saya</a>
        <a href="{{ route('kaprodi.sk-saya') }}" class="menu-item {{ request()->routeIs('kaprodi.sk-saya', 'kaprodi.sk-saya.*') ? 'active' : '' }}"><i class="fas fa-file-download"></i>Download SK</a>
        <details class="menu-group" {{ $nilaiAktif ? 'open' : '' }}>
            <summary class="menu-item {{ $nilaiAktif ? 'active' : '' }}"><i class="fas fa-star-half-alt"></i>Input Nilai<i class="fas fa-chevron-down chev"></i></summary>
            <a href="{{ route('kaprodi.nilai-lkp.index') }}" class="menu-item sub {{ request()->routeIs('kaprodi.nilai-lkp.*') ? 'active' : '' }}">Seminar LKP</a>
            <a href="{{ route('kaprodi.nilai-proposal.index') }}" class="menu-item sub {{ request()->routeIs('kaprodi.nilai-proposal.*') ? 'active' : '' }}">Seminar Proposal</a>
            <a href="{{ route('kaprodi.nilai-sidang.index') }}" class="menu-item sub {{ request()->routeIs('kaprodi.nilai-sidang.*') ? 'active' : '' }}">Sidang Skripsi</a>
        </details>

        <div class="menu-cat">Akun</div>
        <a href="{{ route('kaprodi.profile') }}" class="menu-item {{ request()->routeIs('kaprodi.profile') ? 'active' : '' }}"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item menu-logout"><i class="fas fa-sign-out-alt"></i>Logout</button></form>
    </nav>
</aside>