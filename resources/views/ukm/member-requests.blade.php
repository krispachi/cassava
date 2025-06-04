@extends('layouts.app')

@section('title', 'Permohonan Anggota UKM')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-person-plus me-2"></i>
                            Permohonan Anggota UKM - {{ $pembina->ukm->nama_ukm }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($pendingRequests->isEmpty())
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Tidak ada permohonan anggota yang menunggu persetujuan.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingRequests as $index => $request)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                            <span class="text-white fw-bold">{{ strtoupper(substr($request->mahasiswa->user->name, 0, 1)) }}</span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $request->mahasiswa->user->name }}</div>
                                                            <div class="text-muted small">{{ $request->mahasiswa->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $request->mahasiswa->nim }}</td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approveModal{{ $request->id }}">
                                                            <i class="bi bi-check-lg"></i> Setujui
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal{{ $request->id }}">
                                                            <i class="bi bi-x-lg"></i> Tolak
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Setujui Permohonan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('ukm.membership.approve', $request->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menyetujui permohonan keanggotaan dari <strong>{{ $request->mahasiswa->user->name }}</strong>?</p>
                                                                <div class="mb-3">
                                                                    <label for="notes{{ $request->id }}" class="form-label">Catatan (Opsional)</label>
                                                                    <textarea class="form-control" id="notes{{ $request->id }}" name="notes" rows="3" placeholder="Catatan untuk mahasiswa..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="bi bi-check-lg"></i> Setujui
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Permohonan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('ukm.membership.reject', $request->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menolak permohonan keanggotaan dari <strong>{{ $request->mahasiswa->user->name }}</strong>?</p>
                                                                <div class="mb-3">
                                                                    <label for="reject_notes{{ $request->id }}" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="reject_notes{{ $request->id }}" name="notes" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="bi bi-x-lg"></i> Tolak
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
