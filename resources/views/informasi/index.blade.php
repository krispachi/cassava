@extends('components.main')

@section('title', 'Pusat Informasi - Cassava')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <h1 class="app-content-headerText">Pusat Informasi</h1>
    </div>
    <div class="app-content">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tentang CASSAVA</h3>
                    </div>
                    <div class="card-body">
                        <h4>Campus Activity System and Student Achievement Validation</h4>
                        <p class="mt-3">
                            CASSAVA adalah platform manajemen Unit Kegiatan Mahasiswa (UKM) dan Transkrip Aktivitas
                            Kemahasiswaan (TAK) yang dirancang untuk memudahkan:
                        </p>
                        <ul class="mt-2">
                            <li>Pengelolaan kegiatan UKM</li>
                            <li>Pendaftaran dan absensi kegiatan mahasiswa</li>
                            <li>Pencatatan dan validasi poin TAK</li>
                            <li>Manajemen keanggotaan UKM</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Petunjuk Penggunaan</h3>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="petunjukAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Untuk Mahasiswa
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#petunjukAccordion">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Lihat daftar UKM di menu <strong>UKM</strong></li>
                                            <li>Bergabung dengan UKM yang diminati dengan klik tombol <strong>Gabung</strong></li>
                                            <li>Lihat kegiatan yang tersedia di menu <strong>Kegiatan</strong></li>
                                            <li>Lakukan absensi dengan scan QR Code atau masukkan kode kegiatan</li>
                                            <li>Pantau poin TAK di menu <strong>Poin TAK</strong></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Untuk Pembina UKM
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#petunjukAccordion">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Kelola UKM di menu <strong>UKM</strong></li>
                                            <li>Buat kegiatan baru di menu <strong>Kegiatan</strong></li>
                                            <li>Pantau kehadiran peserta dengan melihat daftar peserta di halaman detail kegiatan</li>
                                            <li>Lihat riwayat kegiatan di menu <strong>Riwayat Kegiatan</strong></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Kontak</h3>
                    </div>
                    <div class="card-body">
                        <p>Jika Anda memiliki pertanyaan atau mengalami kendala, silakan hubungi kami:</p>
                        <ul>
                            <li><strong>Email:</strong> admin@cassava.ac.id</li>
                            <li><strong>Telepon:</strong> 0812-3456-7890</li>
                            <li><strong>Jam Kerja:</strong> Senin - Jumat, 08:00 - 16:00 WIB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
