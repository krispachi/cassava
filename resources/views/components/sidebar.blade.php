<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route("home.index") }}" class="brand-link">
            <img src="{{ asset("images/Logo Cassava Rounded.png") }}" alt="AdminLTE Logo" class="brand-image shadow" />
            <span class="brand-text fw-light">Cassava</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">BERANDA</li>
                <li class="nav-item">
                    <a href="{{ route("dashboard.index") }}" class="nav-link {{ Request::is("dashboard*") ? "active" : "" }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ route("tak.index") }}" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-data"></i>
                        <p>Poin TAK</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("kegiatan-ukm.index") }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Kegiatan UKM</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("kegiatan-ukm.riwayat.index") }}" class="nav-link">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>Riwayat Kegiatan</p>
                    </a>
                </li>
                <li class="nav-header">BANTUAN</li>
                <li class="nav-item">
                    <a href="{{ route("pusat-informasi.index") }}" class="nav-link">
                        <i class="nav-icon bi bi-info-circle"></i>
                        <p>Pusat Informasi</p>
                    </a>
                </li>
                <li class="nav-header">AKUN</li>
                <li class="nav-item">
                    <a href="{{ route("users.index") }}" class="nav-link {{ Request::is("users*") && !Request::is("profile*") ? "active" : "" }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("users.profile") }}" class="nav-link {{ Request::is("profile*") ? "active" : "" }}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                      <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="nav-link border-0 bg-transparent">
            <i class="nav-icon bi bi-door-closed"></i>
            <p>Log Out</p>
        </button>
    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>