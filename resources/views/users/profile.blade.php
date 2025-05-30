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
                        {{-- ## untuk admin aja --}}
                        <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
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
                            <div class="text-center mb-3">
                                <img class="rounded-4 shadow" src="{{ asset("images/Logo Cassava Rounded.png") }}" width="100" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">Angga Krisna Tude</h3>
                            <p class="text-muted text-center">Mahasiswa | Software Engineer</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-end text-decoration-none" style="color: #334155">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-end text-decoration-none" style="color: #334155">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-end text-decoration-none" style="color: #334155">13,287</a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-block text-white" style="background-color: #0A2463"><b><i class="fa-solid fa-user-plus me-2"></i>Follow</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #0A2463">
                            <h3 class="card-title"><i class="fa-solid fa-clock-rotate-left me-2"></i>Jejak Keaktifan</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>
                            <p class="text-muted">B.S. in Computer Science from the University of Tennessee at Knoxville</p>

                            <hr>
                            
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">Malibu, California</p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr>
                            
                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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