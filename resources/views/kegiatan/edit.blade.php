@extends('components.main')

@section('title', 'Edit Kegiatan - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Edit Kegiatan</h1>
        <a href="{{ route('kegiatan.show', $kegiatan) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Kegiatan: {{ $kegiatan->nama_kegiatan }}</h3>
                    </div>

                    <div class="card-body">
                    <form action="{{ route('kegiatan.update', $kegiatan) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">UKM</label>
                            <input type="text" class="form-control" value="{{ $kegiatan->ukm->nama_ukm }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal & Jam Mulai</label>
                                    <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('Y-m-d\TH:i')) }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal & Jam Selesai</label>
                                    <input type="datetime-local" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('Y-m-d\TH:i')) }}" required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poin_tak" class="form-label">Poin TAK</label>
                            <input type="number" class="form-control @error('poin_tak') is-invalid @enderror" id="poin_tak" name="poin_tak" value="{{ old('poin_tak', $kegiatan->poin_tak) }}" min="0" step="0.1" required>
                            @error('poin_tak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $kegiatan->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="aktif" {{ old('status', $kegiatan->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ old('status', $kegiatan->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="generate_new_qr" name="generate_new_qr" value="1">
                                <label class="form-check-label" for="generate_new_qr">
                                    Generate QR Code baru untuk kegiatan ini
                                </label>
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Perhatian: QR Code lama tidak akan berlaku lagi jika diubah
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kegiatan.show', $kegiatan) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
