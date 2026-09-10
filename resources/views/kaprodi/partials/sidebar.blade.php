<aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><a href="#" class="sidebar-brand"><i class="fas fa-user-tie"></i><span>Kaprodi Panel</span></a></div>
    <nav class="sidebar-menu">
        <div class="menu-cat">Menu Utama</div>
        <a href="{{ route('kaprodi.dashboard') }}" class="menu-item {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>Dashboard</a>
        <a href="{{ route('kaprodi.bimbingan.index') }}" class="menu-item {{ request()->routeIs('kaprodi.bimbingan.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i>Bimbingan</a>
        <a href="{{ route('kaprodi.seminar') }}" class="menu-item {{ request()->routeIs('kaprodi.seminar') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i>Seminar LKP</a>
        <a href="{{ route('kaprodi.sidang.index') }}" class="menu-item {{ request()->routeIs('kaprodi.sidang.*') ? 'active' : '' }}"><i class="fas fa-gavel"></i>Sidang</a>
        <a href="{{ route('kaprodi.jadwal-saya') }}" class="menu-item {{ request()->routeIs('kaprodi.jadwal-saya') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Jadwal Saya</a>
        <a href="{{ route('kaprodi.sk-pembimbing.index') }}" class="menu-item {{ request()->routeIs('kaprodi.sk-pembimbing.*') ? 'active' : '' }}"><i class="fas fa-file-signature"></i>SK Pembimbing</a>
        <div class="menu-cat" style="margin-top:1.5rem;">Lainnya</div>
        <a href="{{ route('kaprodi.profile') }}" class="menu-item {{ request()->routeIs('kaprodi.profile') ? 'active' : '' }}"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i>Logout</button></form>
    </nav>
</aside>