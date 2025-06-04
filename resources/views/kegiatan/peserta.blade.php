@extends('components.main')

@section('title', 'Peserta Kegiatan - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Peserta Kegiatan</h1>
        <a href="{{ route('kegiatan.show', $kegiatan) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Kegiatan
        </a>
    </div>
    <div class="app-content">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3>Peserta Kegiatan: {{ $kegiatan->nama_kegiatan }}</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Program Studi</th>
                                    <th>Fakultas</th>
                                    <th>Waktu Absen</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($peserta->count() > 0)
                                    @foreach($peserta as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->mahasiswa->nim }}</td>
                                        <td>{{ $item->mahasiswa->user->name }}</td>
                                        <td>{{ $item->mahasiswa->prodi }}</td>
                                        <td>{{ $item->mahasiswa->fakultas }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->waktu_absen)->format('d M Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->status === 'hadir' ? 'success' : 'danger' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada peserta yang hadir</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total Peserta: {{ $peserta->count() }}</span>

                        <!-- Fitur ekspor bisa ditambahkan di sini jika dibutuhkan -->
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Ekspor ke Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
