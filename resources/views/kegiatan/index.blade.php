@extends('components.main')

@section('title', 'Daftar Kegiatan - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Daftar Kegiatan</h1>
        @if($user->isPembina() && $user->pembina)
            <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Buat Kegiatan Baru
            </a>
        @endif
    </div>
    <div class="app-content">
        <div class="row mb-4">
            <div class="col-md-12">
            </div>
        </div>

    <div class="row">
        @if($kegiatan->count() > 0)
            @foreach($kegiatan as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ $item->nama_kegiatan }}</h5>
                        <span class="badge bg-{{ $item->status === 'draft' ? 'secondary' : ($item->status === 'aktif' ? 'primary' : 'success') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>

                        <div class="mb-2">
                            <strong>UKM:</strong> {{ $item->ukm->nama_ukm }}
                        </div>

                        <div class="mb-2">
                            <strong>Tanggal:</strong> <br>
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y H:i') }} -
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y H:i') }}
                        </div>

                        <div class="mb-2">
                            <strong>Lokasi:</strong> {{ $item->lokasi ?? 'Belum ditentukan' }}
                        </div>

                        <div>
                            <strong>Poin TAK:</strong> {{ $item->poin_tak }}
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('kegiatan.show', $item) }}" class="btn btn-info">Detail</a>

                        @if($user->isPembina() && $user->pembina && $user->pembina->ukm_id == $item->ukm_id)
                            <a href="{{ route('kegiatan.edit', $item) }}" class="btn btn-warning">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-info">
                    Belum ada kegiatan yang tersedia.
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
