@extends('components.main')

@section('title', 'Edit UKM -                     </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Edit UKM</h1>
        <a href="{{ route('ukm.show', $ukm) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit UKM - {{ $ukm->nama_ukm }}</h3>
                    </div>

                <div class="card-body">
                    <form action="{{ route('ukm.update', $ukm) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_ukm" class="form-label">Nama UKM</label>
                            <input type="text" class="form-control @error('nama_ukm') is-invalid @enderror" id="nama_ukm" name="nama_ukm" value="{{ old('nama_ukm', $ukm->nama_ukm) }}" required>
                            @error('nama_ukm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $ukm->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo UKM</label>
                            @if($ukm->logo && file_exists(public_path('storage/' . $ukm->logo)))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            <div class="form-text">Format: JPG, PNG, GIF, SVG. Max: 2MB</div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('ukm.show', $ukm) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
