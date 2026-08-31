<aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><a href="#" class="sidebar-brand"><i class="fas fa-user-shield"></i><span>Dekan Panel</span></a></div>
    <nav class="sidebar-menu">
        <div class="menu-cat">Menu Utama</div>
        <a href="{{ route('dekan.dashboard') }}" class="menu-item {{ request()->routeIs('dekan.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>Dashboard</a>
        <a href="{{ route('dekan.seminar') }}" class="menu-item {{ request()->routeIs('dekan.seminar') ? 'active' : '' }}"><i class="fas fa-file-alt"></i>Seminar LKP</a>
        <a href="{{ route('dekan.jadwal') }}" class="menu-item {{ request()->routeIs('dekan.jadwal') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Jadwal Seminar</a>
        <a href="{{ route('dekan.proposal') }}" class="menu-item {{ request()->routeIs('dekan.proposal') ? 'active' : '' }}"><i class="fas fa-file-contract"></i>Proposal</a>
        <a href="{{ route('dekan.sidang') }}" class="menu-item {{ request()->routeIs('dekan.sidang') ? 'active' : '' }}"><i class="fas fa-gavel"></i>Sidang</a>
        <div class="menu-cat" style="margin-top:.75rem;">Sebagai Pembimbing</div>
        <a href="{{ route('dekan.bimbingan.index') }}" class="menu-item {{ request()->routeIs('dekan.bimbingan.*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i>Mahasiswa Bimbingan</a>
        <a href="{{ route('dekan.jadwal-saya') }}" class="menu-item {{ request()->routeIs('dekan.jadwal-saya') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i>Jadwal Saya</a>
        <div class="menu-cat" style="margin-top:1.5rem;">Lainnya</div>
        <a href="{{ route('dekan.profile') }}" class="menu-item {{ request()->routeIs('dekan.profile') ? 'active' : '' }}"><i class="fas fa-user"></i>Profil Saya</a>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="menu-item" style="width:100%;text-align:left;background:none;border:none;color:inherit;"><i class="fas fa-sign-out-alt"></i>Logout</button></form>
    </nav>
</aside>