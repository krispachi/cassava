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
                            <div class="display-4">
                                <i class="bi bi-speedometer2"></i>
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
                <div class="small-box bg-gradient-warning shadow-sm rounded-3">
                    <div class="inner">
                        <h3>{{ $stats['total_pembina'] }}</h3>
                        <p>Total Pembina</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer rounded-bottom">
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning-fill me-2"></i>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('admin.ukm.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i><br>
                                    Buat UKM Baru
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('admin.ukm-management') }}" class="btn btn-info w-100">
                                    <i class="bi bi-gear"></i><br>
                                    Kelola UKM
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('users.index') }}" class="btn btn-success w-100">
                                    <i class="bi bi-people"></i><br>
                                    Kelola Users
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-warning w-100">
                                    <i class="bi bi-calendar-event"></i><br>
                                    Kelola Kegiatan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent UKMs -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-clock-history me-2"></i>
                            UKM Terbaru
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($recent_ukms->isEmpty())
                            <p class="text-muted text-center">Belum ada UKM yang dibuat</p>
                        @else
                            @foreach($recent_ukms as $ukm)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        @if($ukm->logo)
                                            <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->nama_ukm }}"
                                                 class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($ukm->nama_ukm, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>                                        <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $ukm->nama_ukm }}</h6>
                                        <small class="text-muted">
                                            Pembina: {{ $ukm->pembina && $ukm->pembina->user ? $ukm->pembina->user->name : 'Belum ada pembina' }}
                                        </small>
                                    </div>
                                    <small class="text-muted">{{ $ukm->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Membership Requests -->
        @if($recent_requests->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-person-plus me-2"></i>
                                Permohonan Keanggotaan Terbaru
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mahasiswa</th>
                                            <th>UKM</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_requests as $request)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($request->mahasiswa && $request->mahasiswa->user)
                                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 30px; height: 30px;">
                                                                <span class="text-white small fw-bold">{{ strtoupper(substr($request->mahasiswa->user->name, 0, 1)) }}</span>
                                                            </div>
                                                            <div>
                                                                <div>{{ $request->mahasiswa->user->name }}</div>
                                                                <small class="text-muted">{{ $request->mahasiswa->nim }}</small>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <div>Mahasiswa tidak ditemukan</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $request->ukm->nama_ukm }}</td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock"></i> Pending
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
