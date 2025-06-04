@extends('layouts.app')

@section('title', 'Status Keanggotaan UKM')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-person-check me-2"></i>
                            Status Keanggotaan UKM Saya
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($memberships->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-person-x display-1 text-muted"></i>
                                <h4 class="mt-3">Belum Ada Keanggotaan</h4>
                                <p class="text-muted">Anda belum mengajukan permohonan keanggotaan ke UKM manapun.</p>
                                <a href="{{ route('mahasiswa.available-ukms') }}" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                    Cari UKM
                                </a>
                            </div>
                        @else
                            <div class="row">
                                @foreach($memberships as $membership)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="card-title mb-0">{{ $membership->ukm->nama_ukm }}</h5>
                                                    @if($membership->status === 'pending')
                                                        <span class="badge bg-warning">
                                                            <i class="bi bi-clock"></i> Menunggu
                                                        </span>
                                                    @elseif($membership->status === 'approved')
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Disetujui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-x-circle"></i> Ditolak
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar"></i>
                                                        Diajukan: {{ $membership->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>

                                                @if($membership->status === 'approved')
                                                    <div class="mb-3">
                                                        <small class="text-success">
                                                            <i class="bi bi-person-badge"></i>
                                                            Jabatan: {{ ucfirst($membership->jabatan) }}
                                                        </small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <small class="text-success">
                                                            <i class="bi bi-calendar-check"></i>
                                                            Disetujui: {{ $membership->approved_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                    @if($membership->approver)
                                                        <div class="mb-3">
                                                            <small class="text-muted">
                                                                <i class="bi bi-person"></i>
                                                                Disetujui oleh: {{ $membership->approver->user->name }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($membership->status === 'rejected')
                                                    <div class="mb-3">
                                                        <small class="text-danger">
                                                            <i class="bi bi-calendar-x"></i>
                                                            Ditolak: {{ $membership->approved_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                    @if($membership->approver)
                                                        <div class="mb-3">
                                                            <small class="text-muted">
                                                                <i class="bi bi-person"></i>
                                                                Ditolak oleh: {{ $membership->approver->user->name }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($membership->approval_notes)
                                                    <div class="alert alert-light p-2">
                                                        <small>
                                                            <strong>
                                                                @if($membership->status === 'approved')
                                                                    Catatan:
                                                                @else
                                                                    Alasan Penolakan:
                                                                @endif
                                                            </strong><br>
                                                            {{ $membership->approval_notes }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($membership->status === 'rejected')
                                                <div class="card-footer">
                                                    <form action="{{ route('ukm.apply', $membership->ukm->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                            <i class="bi bi-arrow-clockwise"></i>
                                                            Daftar Ulang
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
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
