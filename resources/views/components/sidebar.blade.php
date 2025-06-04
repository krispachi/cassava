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
                    <a href="{{ route("dashboard.index") }}" class="nav-link {!! Request::is("dashboard*") && !Request::is("admin/dashboard*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()->peran === 'Admin')
                    <li class="nav-item">
                        <a href="{{ route("admin.dashboard") }}" class="nav-link {!! Request::is("admin/dashboard*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                            <i class="nav-icon bi bi-gear-fill"></i>
                            <p>Admin Dashboard</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">MENU</li>
                <li class="nav-item">
                    <a href="{{ route("tak.index") }}" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-data"></i>
                        <p>Poin TAK</p>
                    </a>
                </li>

                @if(auth()->user()->role === 'Mahasiswa')
                    <!-- Menu khusus Mahasiswa -->
              
                @elseif(auth()->user()->role === 'UKM')
                    <!-- Menu khusus Pembina UKM -->

                @endif

                <li class="nav-item">
                    <a href="{{ route("ukm.index") }}" class="nav-link {!! Request::is("ukm*") && !Request::is("ukm-memberships*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>UKM</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("kegiatan.index") }}" class="nav-link {!! Request::is("kegiatan*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-calendar-event"></i>
                        <p>Kegiatan</p>
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
                @if(auth()->user()->role === 'Admin')
                    <!-- Menu Users hanya untuk Admin -->
                    <li class="nav-item">
                        <a href="{{ route("users.index") }}" class="nav-link {!! Request::is("users*") && !Request::is("profile*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route("users.profile") }}" class="nav-link {!! Request::is("profile*") ? 'active text-light" style="background-color: #0A2463;' : '' !!}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="nav-link d-inline-block w-100">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent d-flex p-0">
                            <i class="nav-icon bi bi-door-closed me-2"></i>Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
