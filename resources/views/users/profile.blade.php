@extends("components.main")

@section("title", "Profile User - Cassava")

@php
use Illuminate\Support\Str;
use Carbon\Carbon;
@endphp

@section("headlinks-after-adminlte")
    <style>
        .card.card-outline {
            border-top: 3px solid #0A2463 !important;
        }
    </style>
@endsection

@section("content")
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Profil User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
                        @if (auth()->user()->peran ?? -1 == "Admin")
                            <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info card-outline mb-3">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3 mt-2">
                                @if($user->isMahasiswa() && $user->mahasiswa && isset($user->mahasiswa->foto))
                                    <img class="rounded-4 shadow" src="{{ asset('storage/' . $user->mahasiswa->foto) }}" width="100" height="100" alt="User profile picture">
                                @elseif($user->isPembina() && $user->pembina && isset($user->pembina->foto))
                                    <img class="rounded-4 shadow" src="{{ asset('storage/' . $user->pembina->foto) }}" width="100" height="100" alt="User profile picture">
                                @else
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-4 shadow" style="width:100px; height:100px;">
                                        <span style="font-size: 2.5rem;">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ $user->name ?? "(Nama tidak diketahui)" }}</h3>
                            <p class="text-muted text-center">{{ $user->peran ?? "(Peran tidak diketahui)" }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>NIM</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->nim ?? "(NIM tidak diketahui)" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->email ?? "(Email tidak diketahui)" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor Telepon</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->nomor_telepon ?? "(Nomor Telepon tidak diketahui)" }}</a>
                                </li>
                                @if($user->isMahasiswa() && $user->mahasiswa)
                                <li class="list-group-item">
                                    <b>Program Studi</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->mahasiswa->prodi ?? "-" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Fakultas</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->mahasiswa->fakultas ?? "-" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Angkatan</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->mahasiswa->angkatan ?? "-" }}</a>
                                </li>
                                @elseif($user->isPembina() && $user->pembina && $user->pembina->ukm)
                                <li class="list-group-item">
                                    <b>UKM</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->pembina->ukm->nama_ukm ?? "-" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Jabatan</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->pembina->jabatan ?? "Pembina" }}</a>
                                </li>
                                @endif
                            </ul>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>TAK Semester Ini</b> <a class="float-end text-decoration-none" style="color: #334155">{{ number_format($takSemesterIni) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total TAK</b> <a class="float-end text-decoration-none" style="color: #334155">{{ number_format($totalTak) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Kegiatan</b> <a class="float-end text-decoration-none" style="color: #334155">{{ number_format($totalKegiatan) }}</a>
                                </li>
                            </ul>
                            {{-- <a href="#" class="btn btn-block text-white" style="background-color: #0A2463"><b><i class="fa-solid fa-user-plus me-2"></i>Follow</b></a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-clock-rotate-left me-1"></i>Jejak Keaktifan</h3>
                        </div>
                        <div class="card-body">
                            @if(count($recentActivities) > 0)
                                @foreach($recentActivities as $activity)
                                    <strong>
                                        <i class="fa-solid fa-thumbtack me-1"></i>
                                        {{ $activity->kegiatan->nama_kegiatan }} - {{ $activity->kegiatan->ukm->nama_ukm }}
                                    </strong>
                                    <p class="text-muted">{{ $activity->kegiatan->deskripsi }}</p>
                                    <p class="small text-end text-secondary">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('d M Y') }}
                                        <span class="badge bg-success ms-2">+{{ $activity->kegiatan->poin_tak }} poin</span>
                                    </p>

                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-calendar-x fs-2 text-muted"></i>
                                    <p class="mt-2 text-muted">Belum ada riwayat kegiatan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($user->isMahasiswa() && $user->mahasiswa)
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-users me-1"></i> Keanggotaan UKM</h3>
                        </div>
                        <div class="card-body">
                            @php
                                // Get Active Memberships
                                $activeUkms = $user->mahasiswa->ukm()
                                    ->where('ukm_anggota.is_active', 1)
                                    ->where('ukm_anggota.status', 'approved')
                                    ->get();

                                // Get Pending Requests
                                $pendingUkms = \App\Models\UkmAnggota::with('ukm')
                                    ->where('mahasiswa_id', $user->mahasiswa->id)
                                    ->where('status', 'pending')
                                    ->get();
                            @endphp

                            <!-- Active Memberships -->
                            <h5 class="mb-3 border-bottom pb-2"><i class="fa-solid fa-check-circle me-1 text-success"></i> UKM yang Diikuti</h5>

                            @if($activeUkms->count() > 0)
                                <div class="row mb-4">
                                @foreach($activeUkms as $ukm)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    @if($ukm->logo)
                                                        <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama_ukm }}"
                                                            class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                            style="width: 40px; height: 40px;">
                                                            {{ substr($ukm->nama_ukm, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title mb-0">{{ $ukm->nama_ukm }}</h5>
                                                </div>
                                                <p class="card-text small">{{ Str::limit($ukm->deskripsi, 100) }}</p>
                                                <a href="{{ route('ukm.show', $ukm) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <div class="text-center py-3 mb-4">
                                    <i class="fa-solid fa-users-slash fs-2 text-muted"></i>
                                    <p class="mt-2 text-muted">Belum mengikuti UKM manapun</p>
                                    <a href="{{ route('ukm.index') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fa-solid fa-search"></i> Jelajahi UKM
                                    </a>
                                </div>
                            @endif

                            <!-- Pending Requests -->
                            @if($pendingUkms->count() > 0)
                                <h5 class="mb-3 border-bottom pb-2"><i class="fa-solid fa-clock me-1 text-warning"></i> Permohonan Keanggotaan</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>UKM</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingUkms as $membership)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($membership->ukm->logo)
                                                                <img src="{{ asset('storage/' . $membership->ukm->logo) }}" alt="{{ $membership->ukm->nama_ukm }}"
                                                                    class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                            @else
                                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                                    style="width: 32px; height: 32px;">
                                                                    <small>{{ substr($membership->ukm->nama_ukm, 0, 1) }}</small>
                                                                </div>
                                                            @endif
                                                            <a href="{{ route('ukm.show', $membership->ukm) }}">{{ $membership->ukm->nama_ukm }}</a>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($membership->created_at)->format('d M Y H:i') }}</td>
                                                    <td><span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Menunggu Persetujuan</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if($user->isPembina() && $user->pembina && $user->pembina->ukm)
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-calendar-days me-1"></i> Kegiatan UKM</h3>
                        </div>
                        <div class="card-body">
                            @php
                                // Get the UKM's activities
                                $kegiatanList = $user->pembina->ukm->kegiatan()->latest()->take(5)->get();
                            @endphp

                            @if($kegiatanList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Kegiatan</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Peserta</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kegiatanList as $kegiatan)
                                                <tr>
                                                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $kegiatan->status === 'draft' ? 'secondary' : ($kegiatan->status === 'aktif' ? 'primary' : 'success') }}">
                                                            {{ ucfirst($kegiatan->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $kegiatan->absensi->count() }} orang</td>
                                                    <td>
                                                        <a href="{{ route('kegiatan.show', $kegiatan) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-end mt-3">
                                    <a href="{{ route('kegiatan.index') }}" class="btn btn-sm btn-primary">
                                        Lihat Semua Kegiatan
                                    </a>
                                    <a href="{{ route('kegiatan.create') }}" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-plus"></i> Buat Kegiatan
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fa-solid fa-calendar-xmark fs-2 text-muted"></i>
                                    <p class="mt-2 text-muted">Belum ada kegiatan yang dibuat</p>
                                    <a href="{{ route('kegiatan.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fa-solid fa-plus"></i> Buat Kegiatan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if($user->peran === 'Admin')
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-shield me-1"></i> Admin Tools</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('users.index') }}" class="card h-100 shadow-sm text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <i class="fa-solid fa-users fs-1 mb-3 text-primary"></i>
                                            <h5>Kelola Users</h5>
                                            <p class="text-muted mb-0 small">Manage user accounts and roles</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('ukm.index') }}" class="card h-100 shadow-sm text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <i class="fa-solid fa-building-user fs-1 mb-3 text-success"></i>
                                            <h5>Kelola UKM</h5>
                                            <p class="text-muted mb-0 small">Manage student activity units</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('kegiatan.index') }}" class="card h-100 shadow-sm text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <i class="fa-solid fa-calendar fs-1 mb-3 text-warning"></i>
                                            <h5>Kelola Kegiatan</h5>
                                            <p class="text-muted mb-0 small">Manage UKM activities</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

@section("bodyscripts")
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection
