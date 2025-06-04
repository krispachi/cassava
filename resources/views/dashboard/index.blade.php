@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Dashboard - {{ Auth::user()->peran }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h5>
                    <p class="card-text">{{ now()->format('l, d F Y') }}</p>

                    @if(Auth::user()->peran === 'Mahasiswa' && isset($pendingMemberships) && $pendingMemberships->count() > 0)
                        <div class="alert alert-warning mt-3 mb-0">
                            <h6 class="alert-heading"><i class="bi bi-exclamation-circle-fill me-2"></i>Permohonan Keanggotaan Menunggu</h6>
                            <p>Anda memiliki {{ $pendingMemberships->count() }} permohonan keanggotaan UKM yang sedang menunggu persetujuan.</p>
                            <a href="{{ route('users.profile') }}" class="alert-link">Lihat status di profil Anda</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <!-- Manajemen User Card -->
            @if(Auth::user()->peran === 'Admin')
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen User</h5>
                        <p class="card-text">Kelola pengguna sistem</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Kelola User</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- UKM Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Unit Kegiatan Mahasiswa</h5>
                        <p class="card-text">
                            @if(Auth::user()->peran === 'UKM')
                                Kelola UKM Anda
                            @elseif(Auth::user()->peran === 'Mahasiswa')
                                Temukan dan ikuti UKM yang tersedia
                            @else
                                Kelola UKM
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('ukm.index') }}" class="btn btn-primary">Lihat UKM</a>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan</h5>
                        <p class="card-text">
                            @if(Auth::user()->peran === 'UKM')
                                Buat dan kelola kegiatan UKM
                            @elseif(Auth::user()->peran === 'Mahasiswa')
                                Ikuti kegiatan dan dapatkan poin TAK
                            @else
                                Kelola semua kegiatan UKM
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-primary">Lihat Kegiatan</a>
                    </div>
                </div>
            </div>

            <!-- TAK Card -->
            @if(Auth::user()->peran === 'Mahasiswa')
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Transkrip Aktivitas Kemahasiswaan</h5>
                        <p class="card-text">Total Poin TAK: {{ isset($takPoints) ? $takPoints : Auth::user()->poin_tak }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('tak.index') }}" class="btn btn-primary">Lihat TAK</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- UKM Membership Card (replacing Status Keanggotaan) -->
            @if(Auth::user()->peran === 'Mahasiswa' && isset($activeMemberships) && $activeMemberships->count() > 0)
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="bi bi-people-fill me-2"></i>UKM Saya</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($activeMemberships as $membership)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                @if($membership->ukm->logo)
                                                    <img src="{{ asset('storage/' . $membership->ukm->logo) }}" alt="{{ $membership->ukm->nama_ukm }}"
                                                        class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width: 40px; height: 40px;">
                                                        <span>{{ substr($membership->ukm->nama_ukm, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <h5 class="card-title mb-0">{{ $membership->ukm->nama_ukm }}</h5>
                                            </div>
                                            <a href="{{ route('ukm.show', $membership->ukm) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Profile Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Profil Saya</h5>
                        <p class="card-text">
                            @if(Auth::user()->peran === 'Mahasiswa')
                                NIM: {{ Auth::user()->nim }}
                            @elseif(Auth::user()->peran === 'UKM')
                                Pembina UKM
                            @else
                                {{ Auth::user()->peran }}
                            @endif
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.profile') }}" class="btn btn-primary">Lihat Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
