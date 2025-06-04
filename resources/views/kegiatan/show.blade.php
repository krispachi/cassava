@extends('components.main')

@section('title', 'Detail Kegiatan - Cassava')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
    #reader {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    #reader video {
        max-width: 100%;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if QR element exists and if we're in a context where scanning is relevant
        const readerElement = document.getElementById('reader');
        const statusElement = document.getElementById('scanStatus');

        if (readerElement && !document.querySelector('.alert-success')) {
            const html5QrCode = new Html5Qrcode("reader");

            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                // Show success message
                if (statusElement) {
                    statusElement.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> QR Code terbaca!</span>';
                }

                // Add a small delay so user can see the success message
                setTimeout(() => {
                    // Handle the scanned code
                    document.getElementById('qr_code').value = decodedText;

                    // Stop scanning
                    html5QrCode.stop().then(() => {
                        // Submit the form
                        document.getElementById('absenForm').submit();
                    }).catch(err => {
                        console.error("Error stopping QR Code scanner:", err);
                        document.getElementById('absenForm').submit();
                    });
                }, 500);
            };

            const config = {
                fps: 10,
                qrbox: {width: 250, height: 250},
                aspectRatio: 1.0
            };

            // Start scanning
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                qrCodeSuccessCallback
            ).catch((err) => {
                console.error("QR Code scanner error:", err);
                // Show a message if camera access was denied or not available
                readerElement.innerHTML =
                    '<div class="p-4 text-center text-danger">' +
                    '<i class="bi bi-camera-video-off fs-1 mb-2"></i><br>' +
                    'Tidak dapat mengakses kamera.<br>Silakan berikan izin kamera atau masukkan kode secara manual.' +
                    '</div>';

                if (statusElement) {
                    statusElement.textContent = 'Silakan gunakan input manual di bawah';
                }
            });

            // Add camera switch button if multiple cameras are available
            html5QrCode.getCameras().then(cameras => {
                if (cameras && cameras.length > 1) {
                    // Create camera switch button
                    const switchBtn = document.createElement('button');
                    switchBtn.className = 'btn btn-sm btn-secondary mt-2';
                    switchBtn.innerHTML = '<i class="bi bi-camera"></i> Ganti Kamera';
                    switchBtn.onclick = function() {
                        html5QrCode.stop().then(() => {
                            // Toggle between front and back camera
                            const newFacingMode = config.facingMode === "environment" ? "user" : "environment";
                            config.facingMode = newFacingMode;

                            html5QrCode.start(
                                { facingMode: newFacingMode },
                                config,
                                qrCodeSuccessCallback
                            );
                        });
                    };

                    // Add button after the reader element
                    readerElement.parentNode.insertBefore(switchBtn, readerElement.nextSibling);
                }
            }).catch(err => {
                console.error("Error getting cameras", err);
            });
        }
    });
</script>
@endpush

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Detail Kegiatan</h1>
        <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="app-content">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1>{{ $kegiatan->nama_kegiatan }}</h1>

                        <div>
                            <span class="badge bg-{{ $kegiatan->status === 'draft' ? 'secondary' : ($kegiatan->status === 'aktif' ? 'primary' : 'success') }} fs-6">
                                {{ ucfirst($kegiatan->status) }}
                            </span>

                            @if($user->isPembina() && $user->pembina && $user->pembina->ukm_id == $kegiatan->ukm_id)
                                <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-warning ms-2">Edit</a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5>Deskripsi Kegiatan</h5>
                            <p>{{ $kegiatan->deskripsi }}</p>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5>Informasi Kegiatan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="150">UKM</th>
                                            <td>{{ $kegiatan->ukm->nama_ukm }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td>{{ $kegiatan->lokasi ?? 'Belum ditentukan' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Poin TAK</th>
                                            <td>{{ $kegiatan->poin_tak }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if($user->isPembina() && $user->pembina && $user->pembina->ukm_id == $kegiatan->ukm_id)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>QR Code Absensi</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="p-4 border rounded d-inline-block mb-3">
                                            {!! QrCode::size(200)->margin(1)->errorCorrection('H')->generate($kegiatan->qr_code) !!}
                                        </div>
                                        <div class="mt-2 mb-3">
                                            <p class="mb-0">Kode Absensi:</p>
                                            <p class="h5 fw-bold text-primary">{{ $kegiatan->qr_code }}</p>
                                            <p class="small text-muted">Bagikan QR code atau kode ini kepada mahasiswa untuk absensi</p>
                                        </div>
                                        <hr>
                                        <div class="mt-3">
                                            <a href="{{ route('kegiatan.peserta', $kegiatan) }}" class="btn btn-primary">
                                                <i class="bi bi-person-check"></i> Lihat Peserta
                                            </a>
                                            <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-outline-secondary ms-2">
                                                <i class="bi bi-pencil"></i> Edit Kegiatan
                                            </a>

                                            @if($kegiatan->status === 'aktif')
                                            <form action="{{ route('kegiatan.refresh-qrcode', $kegiatan) }}" method="post" class="mt-3">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin membuat QR Code baru? QR Code lama tidak akan berfungsi lagi.')">
                                                    <i class="bi bi-arrow-repeat"></i> Generate QR Code Baru
                                                </button>
                                                <div class="small text-muted mt-1">QR Code baru akan menggantikan QR Code yang lama</div>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($user->isMahasiswa() && $user->mahasiswa)
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Absensi Kegiatan</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($isAttended)
                                            <div class="alert alert-success">
                                                <i class="fas fa-check-circle"></i> Anda telah mengikuti kegiatan ini
                                            </div>
                                        @else
                                            @if($kegiatan->status === 'aktif')                                <div class="mb-4">
                                    <h6 class="mb-3 text-center">Scan QR Code untuk Absensi</h6>
                                    <div class="d-flex justify-content-center mb-2">
                                        <div id="reader" class="rounded border" style="width: 100%; max-width: 300px;"></div>
                                    </div>
                                    <div class="text-center small text-muted mb-3 mt-2">
                                        <span id="scanStatus">Arahkan kamera ke QR Code kegiatan</span>
                                    </div>
                                </div>

                                <div class="text-center mb-3">
                                    <div class="fw-bold mb-2">- ATAU -</div>
                                </div>

                                <form action="{{ route('kegiatan.absen', $kegiatan) }}" method="post" id="absenForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="qr_code" class="form-label">Masukkan Kode Absensi</label>
                                        <input type="text" class="form-control" id="qr_code" name="qr_code" required
                                            placeholder="Masukkan kode absensi di sini">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-check-circle"></i> Absen Sekarang
                                    </button>
                                </form>
                                            @elseif($kegiatan->status === 'draft')
                                                <div class="alert alert-warning">
                                                    Kegiatan belum dimulai
                                                </div>
                                            @else
                                                <div class="alert alert-secondary">
                                                    Kegiatan telah selesai
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
