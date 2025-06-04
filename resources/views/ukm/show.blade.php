@extends('components.main')

@section('title', 'Detail UKM - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Detail UKM</h1>
        <a href="{{ route('ukm.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="app-content">
        <div class="row mb-4">
            <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1>{{ $ukm->nama_ukm }}</h1>

                        <div>
                            @if($isAdmin)
                                <a href="{{ route('ukm.edit', $ukm) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('ukm.destroy', $ukm) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus UKM ini?')">Hapus</button>
                                </form>
                            @endif

                            @if($user->isMahasiswa())
                                @if($isMember)
                                    <form action="{{ route('ukm.leave', $ukm) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin keluar dari UKM ini?')">Keluar dari UKM</button>
                                    </form>
                                @elseif($isPending)
                                    <span class="badge bg-warning text-dark p-2">Menunggu Persetujuan</span>
                                @else
                                    <form action="{{ route('ukm.join', $ukm) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Gabung UKM</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($ukm->logo && file_exists(public_path('storage/' . $ukm->logo)))
                                <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="img-fluid mb-3">
                            @else
                                <div class="text-center p-5 bg-secondary text-white mb-3">
                                    <h1>{{ substr($ukm->nama_ukm, 0, 2) }}</h1>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-9">
                            <h5>Deskripsi</h5>
                            <p>{{ $ukm->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Kegiatan UKM</h4>
                    @if($user->isPembina() && $user->pembina && $user->pembina->ukm_id == $ukm->id)
                        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-sm">Buat Kegiatan Baru</a>
                    @endif
                </div>

                <div class="card-body">
                    @if($kegiatan->count() > 0)
                        <div class="list-group">
                            @foreach($kegiatan as $k)
                                <a href="{{ route('kegiatan.show', $k) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $k->nama_kegiatan }}</h5>
                                        <span class="badge bg-{{ $k->status === 'draft' ? 'secondary' : ($k->status === 'aktif' ? 'primary' : 'success') }}">
                                            {{ ucfirst($k->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($k->deskripsi, 100) }}</p>
                                    <small>Tanggal: {{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d M Y H:i') }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Tidak ada kegiatan yang tersedia saat ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Anggota UKM</h4>
                </div>

                <div class="card-body">
                    @if($anggota->count() > 0)
                        <div class="list-group">
                            @foreach($anggota as $a)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $a->mahasiswa->user->name }}</h5>
                                        <span class="badge bg-info">{{ ucfirst($a->jabatan) }}</span>
                                    </div>
                                    <p class="mb-1">NIM: {{ $a->mahasiswa->nim }}</p>
                                    <small>{{ $a->mahasiswa->prodi }} - {{ $a->mahasiswa->fakultas }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Belum ada anggota yang terdaftar.</p>
                    @endif
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('headlinks-after-adminlte')
<style>
    .badge.bg-warning {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
    }
</style>
@endsection
