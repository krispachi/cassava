@extends('layouts.app')

@section('title', 'Kelola UKM')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-gear me-2"></i>
                            Kelola UKM
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.ukm.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Tambah UKM Baru
                            </a>
                        </div>
                    </div>


        
                    <div class="card-body">
                        @if($ukms->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-people display-1 text-muted"></i>
                                <h4 class="mt-3">Belum Ada UKM</h4>
                                <p class="text-muted">Mulai dengan membuat UKM pertama Anda.</p>
                                <a href="{{ route('admin.ukm.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus"></i> Buat UKM Baru
                                </a>
                            </div>
                        @else
                            <div class="row">
                                @foreach($ukms as $ukm)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    @if($ukm->logo)
                                                        <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->nama_ukm }}"
                                                             class="rounded mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary rounded d-flex align-items-center justify-content-center mb-2 mx-auto"
                                                             style="width: 80px; height: 80px;">
                                                            <span class="text-white h4 mb-0">{{ strtoupper(substr($ukm->nama_ukm, 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title mb-0">{{ $ukm->nama_ukm }}</h5>
                                                </div>

                                                <p class="card-text text-muted small">{{ Str::limit($ukm->deskripsi, 100) }}</p>

                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-person-badge"></i>
                                                        Pembina: {{ $ukm->pembina->user->name ?? 'Belum ada pembina' }}
                                                    </small>
                                                </div>

                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-people"></i>
                                                        Anggota: {{ $ukm->anggota->count() }} orang
                                                    </small>
                                                </div>

                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar"></i>
                                                        Dibuat: {{ $ukm->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="btn-group w-100">
                                                    <a href="{{ route('admin.ukm.edit', $ukm) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <a href="{{ route('ukm.show', $ukm) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i> Lihat
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $ukm->id }}">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $ukm->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus UKM</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus UKM <strong>{{ $ukm->nama_ukm }}</strong>?</p>
                                                        <div class="alert alert-warning">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Tindakan ini akan menghapus semua data terkait termasuk anggota, kegiatan, dan pembina.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.ukm.delete', $ukm) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
