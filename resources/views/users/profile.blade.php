@extends("components.main")

@section("title", "Profile User - Cassava")

@section("headlinks-after-adminlte")
    <style>
        .card.card-outline {
            border-top: 3px solid #0A2463 !important;
        }
    </style>
@endsection

@section("content")
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Profil User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
                        @if (auth()->user()->peran ?? -1 == "Admin")
                            <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info card-outline mb-3">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3 mt-2">
                                <img class="rounded-4 shadow" src="{{ asset("images/Logo Cassava Rounded.png") }}" width="100" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $user->name ?? "(Nama tidak diketahui)" }}</h3>
                            <p class="text-muted text-center">{{ $user->peran ?? "(Peran tidak diketahui)" }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>NIM</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->nim ?? "(NIM tidak diketahui)" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->email ?? "(Email tidak diketahui)" }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor Telepon</b> <a class="float-end text-decoration-none" style="color: #334155">{{ $user->nomor_telepon ?? "(Nomor Telepon tidak diketahui)" }}</a>
                                </li>
                            </ul>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>TAK Semester Ini</b> <a class="float-end text-decoration-none" style="color: #334155">14</a> {{-- ## perlu menyelesaikan fitur ukm --}}
                                </li>
                                <li class="list-group-item">
                                    <b>Total TAK</b> <a class="float-end text-decoration-none" style="color: #334155">64</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Kegiatan</b> <a class="float-end text-decoration-none" style="color: #334155">13,287</a>
                                </li>
                            </ul>
                            {{-- <a href="#" class="btn btn-block text-white" style="background-color: #0A2463"><b><i class="fa-solid fa-user-plus me-2"></i>Follow</b></a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-clock-rotate-left me-1"></i>Jejak Keaktifan</h3> {{-- ## perlu menyelesaikan fitur ukm --}}
                        </div>
                        <div class="card-body">
                            <strong><i class="fa-solid fa-thumbtack me-1"></i> Mini Class C++ Part 8 - Primakara Developers</strong>
                            <p class="text-muted">Mempelajari tentang penggunaan Pointer didalam Function.</p>

                            <hr>
                            
                            <strong><i class="fas fa-map-marker-alt me-1"></i> Seminar Teknologi - Hima IF</strong>
                            <p class="text-muted">Mengenalkan IoT beserta peluang implementasinya di era digital dengan intergasi AI.</p>

                            <hr>

                            <strong><i class="fa-solid fa-thumbtack me-1"></i> English Zone - English Club</strong>
                            <p class="text-muted">Kegiatan dipenuhi game berbahasa Inggris untuk mengasah kemampuan Mahasiswa sambil refreshing setelah mempelajari materi berat perkuliahan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section("bodyscripts")
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection