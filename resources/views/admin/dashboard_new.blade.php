@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">Selamat Datang, Admin</h2>
                                <p class="mb-0">{{ now()->format('l, d F Y') }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                @if($stats['pending_requests'] > 0)
                                    <div class="me-4 text-center">
                                        <div class="bg-warning rounded-circle position-relative d-inline-block">
                                            <i class="bi bi-bell-fill display-6 text-white p-2"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $stats['pending_requests'] }}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </div>
                                        <div class="small mt-1">Permintaan Pending</div>
                                    </div>
                                @endif
                                <div class="display-4">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info shadow-sm rounded-3">
                    <div class="inner">
                        <h3>{{ $stats['total_ukm'] }}</h3>
                        <p>Total UKM</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <a href="{{ route('admin.ukm-management') }}" class="small-box-footer rounded-bottom">
                        Kelola UKM <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success shadow-sm rounded-3">
                    <div class="inner">
                        <h3>{{ $stats['total_mahasiswa'] }}</h3>
                        <p>Total Mahasiswa</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer rounded-bottom">
                        Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning shadow-sm rounded-3 text-dark">
                    <div class="inner">
                        <h3>{{ $stats['total_pembina'] }}</h3>
                        <p>Total Pembina</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer rounded-bottom text-dark">
                        Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger shadow-sm rounded-3">
                    <div class="inner">
                        <h3>{{ $stats['pending_requests'] }}</h3>
                        <p>Permohonan Pending</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer rounded-bottom">
                        Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Quick Actions -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold mb-0">
                            <i class="bi bi-lightning-fill me-2 text-warning"></i>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{ route('admin.ukm.create') }}" class="card h-100 text-decoration-none shadow-hover transition bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="display-5 text-primary mb-3">
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </div>
                                        <h5 class="mb-0">Buat UKM Baru</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.ukm-management') }}" class="card h-100 text-decoration-none shadow-hover transition bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="display-5 text-info mb-3">
                                            <i class="bi bi-gear-fill"></i>
                                        </div>
                                        <h5 class="mb-0">Kelola UKM</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('users.index') }}" class="card h-100 text-decoration-none shadow-hover transition bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="display-5 text-success mb-3">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <h5 class="mb-0">Kelola Users</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('kegiatan.index') }}" class="card h-100 text-decoration-none shadow-hover transition bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="display-5 text-warning mb-3">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </div>
                                        <h5 class="mb-0">Kelola Kegiatan</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent UKMs -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold mb-0">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            UKM Terbaru
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($recent_ukms->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-building-fill-x display-4 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada UKM yang dibuat</p>
                            </div>
                        @else
                            @foreach($recent_ukms as $ukm)
                                <div class="card mb-2 shadow-sm border-0">
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if($ukm->logo)
                                                    <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->nama_ukm }}"
                                                        class="rounded-circle shadow-sm border" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px;">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($ukm->nama_ukm, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $ukm->nama_ukm }}</h6>
                                                <small class="d-flex align-items-center text-muted">
                                                    <i class="bi bi-person-badge me-1"></i>
                                                    {{ $ukm->pembina && $ukm->pembina->user ? $ukm->pembina->user->name : 'Belum ada pembina' }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-light text-dark">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $ukm->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Membership Requests -->
        <!-- UKM Statistics & Charts -->
   

        <!-- Upcoming Kegiatan -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold mb-0">
                            <i class="bi bi-calendar-event-fill me-2 text-warning"></i>
                            Kegiatan Mendatang
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(isset($upcoming_kegiatan) && $upcoming_kegiatan->count() > 0)
                            <div class="row">
                                @foreach($upcoming_kegiatan as $kegiatan)
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow-sm border-0 h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $kegiatan->nama_kegiatan }}</h5>
                                                <div class="d-flex align-items-center mb-2">
                                                    @if($kegiatan->ukm->logo)
                                                        <img src="{{ Storage::url($kegiatan->ukm->logo) }}" class="me-2 rounded-circle"
                                                            style="width: 24px; height: 24px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-info rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                            style="width: 24px; height: 24px;">
                                                            <span class="text-white small">{{ substr($kegiatan->ukm->nama_ukm, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                    <span class="text-muted small">{{ $kegiatan->ukm->nama_ukm }}</span>
                                                </div>
                                                <div class="mb-2">
                                                    <i class="bi bi-calendar text-primary me-1"></i>
                                                    <span class="small">{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }} -
                                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}</span>
                                                </div>
                                                <div class="mb-3">
                                                    <i class="bi bi-geo-alt text-danger me-1"></i>
                                                    <span class="small">{{ $kegiatan->lokasi }}</span>
                                                </div>
                                                <div class="text-end mt-2">
                                                    <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada kegiatan mendatang</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Membership Requests -->
        @if($recent_requests->isNotEmpty())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title fw-bold mb-0">
                                <i class="bi bi-person-plus-fill me-2 text-success"></i>
                                Permohonan Keanggotaan Terbaru
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mahasiswa</th>
                                            <th>UKM</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_requests as $request)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($request->mahasiswa && $request->mahasiswa->user)
                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 36px; height: 36px;">
                                                                <span class="text-white small fw-bold">{{ strtoupper(substr($request->mahasiswa->user->name, 0, 1)) }}</span>
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $request->mahasiswa->user->name }}</div>
                                                                <small class="text-muted">{{ $request->mahasiswa->nim }}</small>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <div>Mahasiswa tidak ditemukan</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($request->ukm->logo)
                                                            <img src="{{ Storage::url($request->ukm->logo) }}" alt="{{ $request->ukm->nama_ukm }}"
                                                                class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 24px; height: 24px;">
                                                                <span class="text-white small">{{ strtoupper(substr($request->ukm->nama_ukm, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        {{ $request->ukm->nama_ukm }}
                                                    </div>
                                                </td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-hourglass-split me-1"></i> Pending
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <form action="{{ route('admin.memberships.approve', $request->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui permintaan keanggotaan ini?')">
                                                                <i class="bi bi-check-lg"></i> Terima
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.memberships.reject', $request->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak permintaan keanggotaan ini?')">
                                                                <i class="bi bi-x-lg"></i> Tolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-list-ul me-1"></i> Lihat Semua Permohonan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Activity Log -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold mb-0">
                            <i class="bi bi-activity me-2 text-danger"></i>
                            Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @if(isset($recent_activities) && $recent_activities->count() > 0)
                                @foreach($recent_activities as $activity)
                                    <div class="list-group-item py-3">
                                        <div class="d-flex">
                                            @if($activity['type'] == 'membership_approved')
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="activity-icon bg-success text-white">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1">Permintaan Keanggotaan Disetujui</h6>
                                                        <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">
                                                        {{ $activity['data']->mahasiswa->user->name }} telah disetujui menjadi anggota {{ $activity['data']->ukm->nama_ukm }}
                                                    </p>
                                                </div>
                                            @elseif($activity['type'] == 'membership_rejected')
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="activity-icon bg-danger text-white">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1">Permintaan Keanggotaan Ditolak</h6>
                                                        <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">
                                                        Permintaan {{ $activity['data']->mahasiswa->user->name }} untuk bergabung dengan {{ $activity['data']->ukm->nama_ukm }} ditolak
                                                    </p>
                                                </div>
                                            @elseif($activity['type'] == 'ukm_created')
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="activity-icon bg-primary text-white">
                                                        <i class="bi bi-plus-circle-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1">UKM Baru Dibuat</h6>
                                                        <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">
                                                        UKM baru "{{ $activity['data']->nama_ukm }}" telah dibuat
                                                    </p>
                                                </div>
                                            @elseif($activity['type'] == 'kegiatan_created')
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="activity-icon bg-warning text-white">
                                                        <i class="bi bi-calendar-plus-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1">Kegiatan Baru Dibuat</h6>
                                                        <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0">
                                                        Kegiatan baru "{{ $activity['data']->nama_kegiatan }}" dibuat oleh {{ $activity['data']->ukm->nama_ukm }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-clock-history display-4 text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada aktivitas terbaru</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Membership Statistics Chart
        const membershipCtx = document.getElementById('membershipChart').getContext('2d');
        const membershipChart = new Chart(membershipCtx, {
            type: 'pie',
            data: {
                labels: ['Disetujui', 'Pending', 'Ditolak'],
                datasets: [{
                    data: [{{ $stats['approved_requests'] ?? 0 }}, {{ $stats['pending_requests'] ?? 0 }}, {{ $stats['rejected_requests'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)', // Green for approved
                        'rgba(255, 193, 7, 0.7)', // Yellow for pending
                        'rgba(220, 53, 69, 0.7)'  // Red for rejected
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Distribusi Status Keanggotaan'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Kegiatan Statistics Chart
        const kegiatanCtx = document.getElementById('kegiatanChart').getContext('2d');
        const kegiatanChart = new Chart(kegiatanCtx, {
            type: 'bar',
            data: {
                labels: ['Sedang Berlangsung', 'Mendatang'],
                datasets: [{
                    label: 'Jumlah Kegiatan',
                    data: [{{ $stats['active_kegiatan'] ?? 0 }}, {{ $stats['upcoming_kegiatan'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.7)', // Blue for active
                        'rgba(255, 193, 7, 0.7)'   // Yellow for upcoming
                    ],
                    borderColor: [
                        'rgba(23, 162, 184, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Status Kegiatan UKM'
                    }
                }
            }
        });
    });
</script>
@endsection

<!-- Additional custom CSS for the activity log -->
<style>
    .activity-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 1.2rem;
    }

    .list-group-item:hover {
        background-color: rgba(0,0,0,.03);
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
@endsection
