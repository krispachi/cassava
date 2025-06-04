@extends('layouts.app')

@section('title', 'Daftar UKM')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-search me-2"></i>
                            Daftar UKM Tersedia
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($ukms as $ukm)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $ukm->nama_ukm }}</h5>
                                            <p class="card-text text-muted">{{ Str::limit($ukm->deskripsi, 100) }}</p>

                                            <div class="mb-3">
                                                <small class="text-muted">
                                                    <i class="bi bi-person-badge"></i>
                                                    Pembina: {{ $ukm->pembina->user->name ?? 'Belum ada pembina' }}
                                                </small>
                                            </div>

                                            @if($ukm->membership_status)
                                                @if($ukm->membership_status === 'pending')
                                                    <div class="alert alert-warning p-2 mb-2">
                                                        <small>
                                                            <i class="bi bi-clock"></i>
                                                            Menunggu persetujuan pembina
                                                        </small>
                                                    </div>
                                                @elseif($ukm->membership_status === 'approved')
                                                    <div class="alert alert-success p-2 mb-2">
                                                        <small>
                                                            <i class="bi bi-check-circle"></i>
                                                            Anda sudah menjadi anggota
                                                        </small>
                                                    </div>
                                                @elseif($ukm->membership_status === 'rejected')
                                                    <div class="alert alert-danger p-2 mb-2">
                                                        <small>
                                                            <i class="bi bi-x-circle"></i>
                                                            Permohonan ditolak
                                                        </small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            @if(!$ukm->membership_status)
                                                <form action="{{ route('ukm.apply', $ukm->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <i class="bi bi-person-plus"></i>
                                                        Daftar Jadi Anggota
                                                    </button>
                                                </form>
                                            @elseif($ukm->membership_status === 'rejected')
                                                <form action="{{ route('ukm.apply', $ukm->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                        Daftar Ulang
                                                    </button>
                                                </form>
                                            @elseif($ukm->membership_status === 'pending')
                                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                                    <i class="bi bi-clock"></i>
                                                    Menunggu Persetujuan
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm w-100" disabled>
                                                    <i class="bi bi-check-circle"></i>
                                                    Sudah Menjadi Anggota
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($ukms->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-people display-1 text-muted"></i>
                                <h4 class="mt-3">Belum Ada UKM</h4>
                                <p class="text-muted">Saat ini belum ada UKM yang tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
