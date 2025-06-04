@extends('components.main')

@section('title', 'Unit Kegiatan Mahasiswa - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Daftar UKM</h1>
        @if(Auth::user()->peran === 'Admin')
            <a href="{{ route('ukm.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah UKM Baru
            </a>
        @endif
    </div>
    <div class="app-content">
        <div class="row mb-4">

    <div class="row">
        @foreach($ukms as $ukm)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title">{{ $ukm->nama_ukm }}</h5>
                </div>

                <div class="card-body">
                    @if($ukm->logo && file_exists(public_path('storage/' . $ukm->logo)))
                        <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="img-fluid mb-3 ukm-logo">
                    @else
                        <div class="text-center p-3 bg-secondary text-white mb-3">
                            <h2>{{ substr($ukm->nama_ukm, 0, 2) }}</h2>
                        </div>
                    @endif

                    <p class="card-text">{{ Str::limit($ukm->deskripsi, 100) }}</p>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('ukm.show', $ukm) }}" class="btn btn-info">Detail</a>

                        @if($user->isMahasiswa() && $user->mahasiswa)
                            @if(in_array($ukm->id, $joinedUkms))
                                <span class="badge bg-success">Anggota</span>
                            @elseif(isset($pendingUkms) && in_array($ukm->id, $pendingUkms))
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @else
                                <form action="{{ route('ukm.join', $ukm) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Gabung</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</main>
@endsection

@section('headlinks-after-adminlte')
<style>
    .ukm-logo {
        max-height: 150px;
        object-fit: contain;
    }

    .badge.bg-warning {
        padding: 0.35rem 0.65rem;
    }
</style>
@endsection
