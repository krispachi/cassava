@extends('layouts.app')

@section('title', 'Edit UKM')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-pencil me-2"></i>
                            Edit UKM - {{ $ukm->nama_ukm }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.ukm-management') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.ukm.update', $ukm) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- UKM Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_ukm" class="form-label">Nama UKM <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_ukm') is-invalid @enderror"
                                               id="nama_ukm" name="nama_ukm" value="{{ old('nama_ukm', $ukm->nama_ukm) }}" required>
                                        @error('nama_ukm')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo UKM</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                               id="logo" name="logo" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah logo.</div>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi UKM <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                          id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $ukm->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Logo -->
                            @if($ukm->logo)
                                <div class="mb-3">
                                    <label class="form-label">Logo Saat Ini:</label>
                                    <div>
                                        <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->nama_ukm }}"
                                             class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Preview New Logo -->
                            <div class="mb-3" id="logoPreview" style="display: none;">
                                <label class="form-label">Preview Logo Baru:</label>
                                <div>
                                    <img id="previewImage" src="" alt="Logo Preview"
                                         class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                </div>
                            </div>

                            <hr>

                            <!-- Pembina Information -->
                            <h5 class="mb-3">
                                <i class="bi bi-person-badge me-2"></i>
                                Informasi Pembina
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pembina_user_id" class="form-label">Pilih Pembina <span class="text-danger">*</span></label>
                                        <select class="form-select @error('pembina_user_id') is-invalid @enderror"
                                                id="pembina_user_id" name="pembina_user_id" required>
                                            <option value="">-- Pilih User Pembina --</option>
                                            @foreach($availablePembinas as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('pembina_user_id', $ukm->pembina->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pembina_user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                               id="nip" name="nip" value="{{ old('nip', $ukm->pembina->nip ?? '') }}" required>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                <input type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror"
                                       id="bidang_keahlian" name="bidang_keahlian"
                                       value="{{ old('bidang_keahlian', $ukm->pembina->bidang_keahlian ?? '') }}"
                                       placeholder="Contoh: Teknologi Informasi, Olahraga, Seni, dll.">
                                @error('bidang_keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.ukm-management') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update UKM
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('logoPreview');
    const previewImage = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endsection
