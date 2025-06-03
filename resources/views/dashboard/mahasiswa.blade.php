@extends('components.main')

@section('title', 'Dashboard Mahasiswa - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Dashboard Mahasiswa</h1>
    </div>
    <div class="app-content">
        <!-- Summary Cards -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="bi bi-award"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total TAK</span>
                        <span class="info-box-number">75</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="bi bi-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TAK Semester Ini</span>
                        <span class="info-box-number">15</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="bi bi-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">UKM Diikuti</span>
                        <span class="info-box-number">2</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('') }}" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Sertifikat
                            </a>
                            <a href="{{ route('') }}" class="btn btn-success">
                                <i class="bi bi-qr-code-scan"></i> Scan Absensi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UKM Yang Diikuti -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">UKM Yang Diikuti</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama UKM</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>UKM Teknologi</td>
                                        <td>Anggota</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    </tr>
                                    <tr>
                                        <td>UKM Olahraga</td>
                                        <td>Anggota</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Kegiatan -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Kegiatan</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Poin TAK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Workshop Programming</td>
                                        <td>2024-03-15</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Seminar Teknologi</td>
                                        <td>2024-03-10</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection