@extends("components.main")

@section("title", "Ubah Users - Cassava")

@section("content")
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Ubah Users</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
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
                        <form action="{{ route("users.update", $user->id) }}" method="POST" id="formUbah">
                            @method("PUT")
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Pengguna</label>
                                    <input type="text" name="name" id="name" class="form-control @error("name") is-invalid @enderror" value="{{ old("name", $user->name) }}" placeholder="Masukkan Nama User" required @error("name") autofocus @enderror>
                                    @error("name")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" name="nim" id="nim" class="form-control @error("nim") is-invalid @enderror" value="{{ old("nim", $user->nim) }}" placeholder="Masukkan NIM User" required @error("nim") autofocus @enderror>
                                    @error("nim")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control @error("nomor_telepon") is-invalid @enderror" value="{{ old("nomor_telepon", $user->nomor_telepon) }}" placeholder="Masukkan Nomor Telepon User" required @error("nomor_telepon") autofocus @enderror>
                                    <div id="emailHelp" class="form-text">Gunakan format +62 atau 0.</div>
                                    @error("nomor_telepon")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="peran" class="form-label">Peran</label>
                                    <select name="peran" id="peran" class="form-select @error("peran") is-invalid @enderror" required @error("peran") autofocus @enderror>
                                        <option selected>Pilih Peran User</option>
                                        <option value="Mahasiswa" {{ old("peran", $user->peran) == "Mahasiswa" ? "selected" : "" }}>Mahasiswa</option>
                                        <option value="Admin" {{ old("peran", $user->peran) == "Admin" ? "selected" : "" }}>Admin</option>
                                        <option value="UKM" {{ old("peran", $user->peran) == "UKM" ? "selected" : "" }}>UKM</option>
                                    </select>
                                    @error("peran")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error("email") is-invalid @enderror" value="{{ old("email", $user->email) }}" placeholder="Masukkan Email User" aria-describedby="emailHelp" required @error("email") autofocus @enderror>
                                    <div id="emailHelp" class="form-text">Kami tidak akan membagikan Email Anda kepada orang lain.</div>
                                    @error("email")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control @error("password") is-invalid @enderror" placeholder="Masukkan Password User" @error("password") autofocus @enderror>
                                    @error("password")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error("password_confirmation") is-invalid @enderror" placeholder="Konfirmasi Password User" aria-describedby="passwordConfirmationHelp" @error("password_confirmation") autofocus @enderror>
                                    <div id="passwordConfirmationHelp" class="form-text">Ketikkan Password sekali lagi untuk konfirmasi.</div>
                                    @error("password_confirmation")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-warning"><i class="fa-solid fa-pen-to-square me-2"></i>Ubah User</button>
                                <a href="{{ route("users.index") }}" class="btn btn-secondary ms-auto"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
                            </div>
                        </form>
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
    $(document).ready(function() {
        // Konfirmasi sebelum ubah
        $("#formUbah").on("submit", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Ubah User',
                text: "Data User akan diubah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FFC107',
                cancelButtonColor: '#17A2B8',
                confirmButtonText: '<p class="m-0 text-body">Ya, ubah!</p>',
                cancelButtonText: 'Batal',
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).unbind("submit").submit();
                }
            });
        });
    });
</script>
@endsection