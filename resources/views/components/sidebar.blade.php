<aside class="app-sidebar bg-body-secondaryWOW shadow" data-bs-theme="light" style="background-color: #F5F7FA !important">
    <div class="sidebar-brand">
        <a href="{{ route("home.index") }}" class="brand-link">
            <img src="{{ asset("images/Logo Cassava Rounded.png") }}" alt="Logo Cassava" class="brand-image rounded-3 shadow-sm" />
            <span class="brand-text fw-bold">Cassava</span>
        </a>
        
    </div>
    <div class="sidebar-wrapper">
        <div class="bg-info rounded-3 py-2">
            <p class="text-center m-0">Campus Activity System and Student Achievement Validation</p>
        </div>

        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">BERANDA</li>
                <li class="nav-item">
                    <a href="{{ route("dashboard.index") }}" class="nav-link {!! Request::is("dashboard*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
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
                    <a href="{{ route("users.index") }}" class="nav-link {!! Request::is("users*") && !Request::is("profile*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("users.profile") }}" class="nav-link {!! Request::is("profile*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("auth.logout") }}" class="nav-link">
                        <i class="nav-icon bi bi-door-closed"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>