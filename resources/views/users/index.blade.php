@extends("components.main")

@section("title", "Users - Cassava")

@section("headlinks-after-adminlte")
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css">
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.css" rel="stylesheet" integrity="sha384-/FgoGbGX5x+MVCTrrHFQKgHo8wY2qiEnzgL3hRQVCx98jC+plKWLKge9hbDtBlL8" crossorigin="anonymous">
@endsection

@section("content")
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Users</h3>
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
                            <h3 class="mb-0">Daftar Pengguna</h3>
                            <a href="{{ route("users.create") }}" class="btn btn-success ms-auto"><i class="fa-solid fa-plus me-2"></i>Tambah User</a>
                        </div>
                        <div class="card-body">
                            <table id="userTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 0%" class="">No.</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Peran</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Row 1 Data 2</td>
                                        <td>Ubah Hapus</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Row 2 Data 2</td>
                                        <td>Ubah Hapus</td>
                                    </tr>
                                </tbody>
                            </table>
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
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.js" integrity="sha384-k7reqywLL1UJzUEpWUO5bRgD8Lu1dX/ptIibiIMKaMM/oyF86G7A2dyGTUpIXJzv" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/df662858df.js" crossorigin="anonymous"></script>

<script>
    let userTable = new DataTable("#userTable", {
        layout: {
            topStart: [
                {
                    buttons: [
                        'excel', 'pdf', 'print', 'colvis'
                    ]
                },
                'pageLength'
            ],
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
        }
    });
</script>
@endsection