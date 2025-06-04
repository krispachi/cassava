@extends('layouts.app')

@push('styles')
<style>
    .badge.bg-primary {
        background-color: #0d6efd !important;
        min-width: 45px;
        text-align: center;
    }
    .badge.bg-warning {
        color: #000 !important;
    }
    .leaderboard-header {
        background-color: #0d6efd;
        color: white;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .leaderboard-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
    }
    .leaderboard-table th {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 12px 15px;
    }
    .leaderboard-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .leaderboard-table tr:nth-child(even) td {
        background-color: #f2f2f2;
    }
    .leaderboard-table tr.highlighted {
        background-color: #cfe2ff;
    }
    .position-badge {
        background-color: #198754;
        color: white;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 20px;
    }
    .points-badge {
        background-color: #0d6efd;
        color: white;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 20px;
    }
    .history-header {
        background-color: #6c757d;
        color: white;
        padding: 10px 15px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
    }
    .status-ditolak {
        background-color: #dc3545;
        color: white;
    }
    .status-menunggu {
        background-color: #ffc107;
        color: black;
    }
    .status-diterima {
        background-color: #198754;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-3 mb-4">Leaderboard TAK</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(Auth::user() && Auth::user()->peran === 'Admin')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tools Sinkronisasi Data</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('sync.user-mahasiswa') }}" class="btn btn-warning">
                            <i class="fas fa-sync-alt me-1"></i> Sinkronisasi User-Mahasiswa
                        </a>
                        <a href="{{ route('sync.tak-points') }}" class="btn btn-success">
                            <i class="fas fa-calculator me-1"></i> Update Poin TAK
                        </a>
                    </div>
                    <div class="mt-2 small text-muted">
                        Gunakan tombol di atas untuk memperbaiki data yang tidak sinkron antara tabel User dan Mahasiswa,
                        atau untuk mengupdate perhitungan poin TAK dari riwayat kegiatan.
                    </div>
                    <div class="mt-3">
                        <h6>Panduan Format NIM</h6>
                        <p class="small text-muted mb-1">Format NIM: 2 digit tahun angkatan + 3 digit kode prodi + nomor urut</p>
                        <ul class="small text-muted list-unstyled">
                            <li><strong>010</strong>: Teknik Informatika</li>
                            <li><strong>020</strong>: Sistem Informasi</li>
                            <li><strong>030</strong>: Manajemen Informatika</li>
                            <li><strong>040</strong>: Ekonomi</li>
                            <li><strong>050</strong>: Akuntansi</li>
                        </ul>
                        <p class="small text-muted">Contoh: <strong>22010001</strong> = Angkatan 2022, Prodi Teknik Informatika</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0">
                <div class="leaderboard-header">
                    <h5 class="mb-0">Leaderboard TAK</h5>
                    <div>
                        <form action="{{ route('tak.index') }}" method="GET" class="form-inline">
                            <select class="form-select" name="angkatan" onchange="this.form.submit()">
                                <option value="">Semua Angkatan</option>
                                @foreach($angkatanList as $angkatan)
                                    <option value="{{ $angkatan }}" {{ $selectedAngkatan == $angkatan ? 'selected' : '' }}>
                                        Angkatan {{ $angkatan }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="leaderboard-table">
                        <thead>
                            <tr>
                                <th style="width: 10%">Rank</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Angkatan</th>
                                <th style="width: 15%">Poin TAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $index => $item)
                                <tr class="{{ Auth::check() && Auth::user()->mahasiswa && Auth::user()->mahasiswa->id == $item->id ? 'highlighted' : '' }}">
                                    <td>{{ $leaderboard->firstItem() + $index }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->angkatan }}</td>
                                    <td><span class="points-badge">{{ $item->poin }}</span></td>
                                </tr>
                            @endforeach

                            @if(count($leaderboard) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>                <div class="card-footer">
                    @if(Auth::check() && Auth::user()->isMahasiswa() && $userRank)
                        <div class="py-2">
                            <p class="mb-0">
                                Posisi Anda:
                                <span class="position-badge">Peringkat #{{ $userRank }}</span>
                                dengan <span class="points-badge">{{ Auth::user()->mahasiswa->total_tak }} poin</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::check() && Auth::user()->isMahasiswa())
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4 border-0">
                <div class="history-header">
                    <h5 class="mb-0">Riwayat TAK Anda</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="leaderboard-table">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($userTAK) && count($userTAK) > 0)
                                    @foreach($userTAK as $tak)
                                        <tr>
                                            <td>{{ $tak->kegiatan->nama_kegiatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tak->created_at)->format('d M Y') }}</td>
                                            <td><span class="points-badge">{{ $tak->poin }}</span></td>
                                            <td>
                                                @if($tak->status == 'diterima' || $tak->status == 'hadir')
                                                    <span class="status-badge status-diterima">Diterima</span>
                                                @elseif($tak->status == 'ditolak' || $tak->status == 'tidak hadir')
                                                    <span class="status-badge status-ditolak">Ditolak</span>
                                                @else
                                                    <span class="status-badge status-menunggu">Menunggu</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Tidak ada riwayat TAK</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(isset($userTAK) && count($userTAK) > 0)
                    <div class="card-footer">
                        {{ $userTAK->appends(['tak_page' => $userTAK->currentPage()])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
</div>
@endsection
