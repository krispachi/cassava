@extends('layouts.app')

@section('title', 'Riwayat Kegiatan UKM')

@push('styles')
<style>
    .kegiatan-img {
        height: 180px;
        object-fit: cover;
        width: 100%;
    }
    .kegiatan-card {
        transition: all 0.3s;
        height: 100%;
    }
    .kegiatan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .kegiatan-title {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        height: 50px;
    }
    .kegiatan-description {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        height: 75px;
        color: #6c757d;
    }
    .badge.attendance {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.8rem;
        padding: 0.5em 0.7em;
    }
    .kegiatan-info {
        color: #6c757d;
        font-size: 0.85rem;
    }
    .kegiatan-info i {
        width: 20px;
        text-align: center;
        margin-right: 5px;
    }
    .tak-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #dee2e6;
        font-weight: bold;
        padding: 0.5em 0.7em;
        border-radius: 5px;
    }
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    /* Additional styles for the enhanced riwayat page */
    .card-footer .btn {
        margin-bottom: 0.3rem;
    }
    .modal-body .table {
        font-size: 0.9rem;
    }
    .alert-info {
        border-left: 4px solid #17a2b8;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script to keep filter state between page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle filter form change events
        const filterForm = document.querySelector('form');
        const filterSelects = filterForm.querySelectorAll('select[onchange]');

        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
@endpush

@section('content')
<div class="container-fluid px-4">    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-3">Riwayat Kegiatan UKM Saya</h1>
            <p class="text-muted">Menampilkan kegiatan UKM yang telah Anda ikuti</p>
            @if(auth()->check() && auth()->user()->peran === 'Mahasiswa' && isset($userTakPoints))
                <p class="text-muted">
                    <i class="fas fa-award me-2"></i>Total Poin TAK Anda: <span class="badge bg-primary">{{ $userTakPoints }} poin</span>
                    <a href="{{ route('tak.index') }}" class="ms-2 text-decoration-none">
                        <i class="fas fa-trophy"></i> Lihat Leaderboard
                    </a>
                </p>
            @endif
        </div>
        <div>
            <a href="{{ route('kegiatan-ukm.index') }}" class="btn btn-primary">
                <i class="fas fa-calendar-check me-2"></i>Kegiatan Aktif
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(auth()->check() && auth()->user()->peran === 'Mahasiswa' && count($availableAngkatan) > 1)
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Berdasarkan Angkatan Peserta</h5>
            <small class="text-muted">Filter kegiatan berdasarkan angkatan peserta lain yang mengikuti kegiatan yang sama</small>
        </div>
        <div class="card-body">
            <form action="{{ route('kegiatan-ukm.riwayat.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="angkatan" class="form-label">Filter by Angkatan</label>
                    <select name="angkatan" id="angkatan" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Angkatan</option>
                        @foreach($availableAngkatan as $tahun)
                            <option value="{{ $tahun }}" {{ $angkatan == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('kegiatan-ukm.riwayat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif    <div class="row mb-4">
        @if(auth()->check() && auth()->user()->peran === 'Mahasiswa')
            @if(count($kegiatan) > 0)
                <div class="col-12 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <h3><i class="fas fa-calendar-check"></i></h3>
                                    <h4>{{ $kegiatan->total() }}</h4>
                                    <p class="mb-0">Kegiatan Diikuti</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3><i class="fas fa-award"></i></h3>
                                    <h4>{{ $kegiatan->sum('poin_tak') }}</h4>
                                    <p class="mb-0">Total Poin TAK</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3><i class="fas fa-users"></i></h3>
                                    <h4>{{ $kegiatan->sum(function($k) { return $k->absensi->where('status', 'hadir')->count(); }) }}</h4>
                                    <p class="mb-0">Total Peserta</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3><i class="fas fa-building"></i></h3>
                                    <h4>{{ $kegiatan->pluck('ukm.nama_ukm')->unique()->count() }}</h4>
                                    <p class="mb-0">UKM Berbeda</p>
                                </div>
                            </div>
                            @if($angkatan)
                                <div class="mt-3 text-center">
                                    <small><i class="fas fa-filter me-1"></i>Menampilkan kegiatan dengan peserta angkatan {{ $angkatan }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 mb-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda belum mengikuti kegiatan UKM apapun. Silakan cek <a href="{{ route('kegiatan-ukm.index') }}">kegiatan aktif</a> untuk bergabung.
                    </div>
                </div>
            @endif
        @else
            <div class="col-12 mb-3">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Halaman ini hanya menampilkan riwayat kegiatan untuk mahasiswa. Silakan login sebagai mahasiswa untuk melihat riwayat kegiatan Anda.
                </div>
            </div>
        @endif

        @forelse($kegiatan as $k)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card kegiatan-card h-100">
                <div class="position-relative">
                    <img src="{{ asset('images/kegiatan-placeholder.jpg') }}" class="kegiatan-img" alt="{{ $k->nama_kegiatan }}">
                    <span class="tak-badge">
                        <i class="fas fa-award"></i> {{ $k->poin_tak }} TAK
                    </span>
                    <!-- User sudah mengikuti semua kegiatan yang ditampilkan -->
                    <span class="badge bg-success attendance">
                        <i class="fas fa-check-circle me-1"></i> Hadir
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title kegiatan-title">{{ $k->nama_kegiatan }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary me-2">{{ $k->ukm->nama_ukm }}</span>
                        <span class="badge bg-secondary">{{ ucfirst($k->status) }}</span>
                    </div>
                    <p class="kegiatan-description">{{ $k->deskripsi }}</p>
                    <div class="kegiatan-info mb-1">
                        <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d M Y') }}
                        @if($k->tanggal_mulai != $k->tanggal_selesai)
                            - {{ \Carbon\Carbon::parse($k->tanggal_selesai)->format('d M Y') }}
                        @endif
                    </div>
                    <div class="kegiatan-info mb-1">
                        <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('H:i') }} WIB
                    </div>
                    <div class="kegiatan-info mb-1">
                        <i class="fas fa-map-marker-alt"></i> {{ $k->lokasi }}
                    </div>
                    <div class="kegiatan-info mb-2">
                        <i class="fas fa-users"></i> {{ $k->absensi->where('status', 'hadir')->count() }} Peserta
                    </div>
                    <div class="kegiatan-info mb-2">
                        <i class="fas fa-certificate"></i> Total {{ $k->absensi->where('status', 'hadir')->count() * $k->poin_tak }} poin TAK diberikan
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2">
                        <a href="{{ route('kegiatan.show', $k->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-info-circle me-1"></i> Detail Kegiatan
                        </a>
                        @if(auth()->user() && (auth()->user()->peran === 'Admin' || auth()->user()->peran === 'UKM'))
                            <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#participantsModal{{ $k->id }}">
                                <i class="fas fa-users me-1"></i> Lihat Peserta
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <h5><i class="fas fa-calendar-times me-2"></i>Belum Ada Kegiatan yang Diikuti</h5>
                <p class="mb-3">Anda belum mengikuti kegiatan UKM apapun.</p>
                <a href="{{ route('kegiatan-ukm.index') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-check me-2"></i>Lihat Kegiatan Aktif
                </a>
            </div>
        </div>
        @endforelse
    </div>    <div class="d-flex justify-content-center">
        {{ $kegiatan->links() }}
    </div>
</div>

@if(auth()->user() && (auth()->user()->peran === 'Admin' || auth()->user()->peran === 'UKM'))
    @foreach($kegiatan as $k)
        <!-- Participants Modal -->
        <div class="modal fade" id="participantsModal{{ $k->id }}" tabindex="-1" aria-labelledby="participantsModalLabel{{ $k->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="participantsModalLabel{{ $k->id }}">
                            Peserta Kegiatan: {{ $k->nama_kegiatan }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6>Informasi Kegiatan:</h6>
                                <span class="badge bg-primary">{{ $k->ukm->nama_ukm }}</span>
                            </div>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d M Y') }}</p>
                            <p><strong>Lokasi:</strong> {{ $k->lokasi }}</p>
                            <p><strong>Poin TAK:</strong> {{ $k->poin_tak }} per mahasiswa</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Program</th>
                                        <th>Angkatan</th>
                                        <th>Status</th>
                                        <th>Poin TAK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($k->absensi->count() > 0)
                                        @foreach($k->absensi as $index => $absen)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $absen->mahasiswa->nim }}</td>
                                                <td>{{ $absen->mahasiswa->user->name }}</td>
                                                <td>{{ $absen->mahasiswa->program }}</td>
                                                <td>{{ $absen->mahasiswa->angkatan }}</td>
                                                <td>
                                                    <span class="badge {{ $absen->status == 'hadir' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($absen->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $absen->status == 'hadir' ? $k->poin_tak : 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data peserta</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection
