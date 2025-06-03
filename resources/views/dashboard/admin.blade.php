@extends('components.main')

@section('title', 'Dashboard Admin - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Dashboard Admin</h1>
    </div>
    <div class="app-content">
        <!-- Summary Cards -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="bi bi-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Mahasiswa</span>
                        <span class="info-box-number">450</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="bi bi-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total UKM</span>
                        <span class="info-box-number">8</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar UKM -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar UKM</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama UKM</th>
                                        <th>Jumlah Anggota</th>
                                        <th>Pembina</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>UKM Teknologi</td>
                                        <td>45</td>
                                        <td>Dr. Putu Wijaya</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    </tr>
                                    <tr>
                                        <td>UKM Olahraga</td>
                                        <td>38</td>
                                        <td>Made Sudiarta, M.Pd.</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
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