@extends('components.main')

@section('title', 'Dashboard - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Dashboard - {{ Auth::user()->peran }}</h1>
    </div>
    <div class="app-content">
        {{-- Welcome Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h5>
                <p class="card-text">{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>

        <div class="row">
            @can('envi-users')
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen User</h5>
                        <p class="card-text">Kelola pengguna sistem</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Kelola User</a>
                    </div>
                </div>
            </div>
            @endcan

            @can('envi-tak')
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transkrip Aktivitas Kemahasiswaan</h5>
                        <p class="card-text">
                            @if(Auth::user()->peran === 'Mahasiswa')
                                Total Poin TAK: {{ Auth::user()->poin_tak }}
                            @else
                                Kelola TAK mahasiswa
                            @endif
                        </p>
                        <a href="{{ route('tak.index') }}" class="btn btn-primary">Kelola TAK</a>
                    </div>
                </div>
            </div>

            @if(Auth::user()->peran === 'Mahasiswa')
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profil Saya</h5>
                        <p class="card-text">NIM: {{ Auth::user()->nim }}</p>
                        <a href="{{ route('users.profile') }}" class="btn btn-primary">Lihat Profil</a>
                    </div>
                </div>
            </div>
            @endif
            @endcan

            @can('envi-ukm')
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan UKM</h5>
                        <p class="card-text">
                            @if(Auth::user()->peran === 'UKM')
                                Kelola kegiatan UKM Anda
                            @else
                                Lihat kegiatan UKM yang tersedia
                            @endif
                        </p>
                        <a href="{{ route('kegiatan-ukm.index') }}" class="btn btn-primary">
                            {{ Auth::user()->peran === 'UKM' ? 'Kelola Kegiatan' : 'Lihat Kegiatan' }}
                        </a>
                    </div>
                </div>
            </div>

            @if(Auth::user()->peran === 'UKM')
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Kegiatan</h5>
                        <p class="card-text">Lihat riwayat kegiatan yang telah dilaksanakan</p>
                        <a href="{{ route('kegiatan-ukm.riwayat.index') }}" class="btn btn-primary">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
            @endif
            @endcan
        </div>
    </div>
</main>
@endsection