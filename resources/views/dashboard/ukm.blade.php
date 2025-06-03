@extends('components.main')

@section('title', 'Dashboard UKM - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Dashboard UKM</h1>
    </div>
    <div class="app-content">
        <!-- Summary Cards -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="bi bi-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Anggota</span>
                        <span class="info-box-number">45</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="bi bi-calendar-event"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kegiatan Aktif</span>
                        <span class="info-box-number">3</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Pembina -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Pembina</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Nama Pembina</th>
                                <td>Dr. Putu Wijaya</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>putu.wijaya@primakara.ac.id</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>08123456789</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- List Kegiatan -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Kegiatan</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Peserta</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Workshop Programming</td>
                                        <td>2024-03-20</td>
                                        <td>25</td>
                                        <td><span class="badge bg-warning">Upcoming</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info">
                                                <i class="bi bi-qr-code"></i> QR Code
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Seminar Teknologi</td>
                                        <td>2024-03-15</td>
                                        <td>40</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-secondary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
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