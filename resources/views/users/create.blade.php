@extends("components.main")

@section("title", "Tambah Users - Cassava")

@section("content")
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Users</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="mb-0">Form User</h3>
                            <a href="{{ route("users.index") }}" class="btn btn-secondary ms-auto"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("users.store") }}">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Pengguna</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="nomor_telepon">
                                    <div id="emailHelp" class="form-text">Gunakan format +62 atau 0.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="peran" class="form-label">Peran</label>
                                    <select class="form-select" id="peran">
                                        <option value="Mahasiswa" selected>Mahasiswa</option>
                                        <option value="Admin">Admin</option>
                                        <option value="UKM">UKM</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                                    <div id="emailHelp" class="form-text">Kami tidak akan membagikan Email Anda kepada orang lain.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                                <div class="mb-3">
                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password-confirmation">
                                    <div id="emailHelp" class="form-text">Ketikkan Password sekali lagi untuk konfirmasi.</div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Kirim Form</button>
                            <a href="{{ route("users.index") }}" class="btn btn-secondary ms-auto"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
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

<script>
    
</script>
@endsection