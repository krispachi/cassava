<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Aktivitas Mahasiswa - Universitas Primakara</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'serif': ['Playfair Display', 'serif'],
                    },
                    colors: {
                        'primakara-blue': '#0A2463', // Warna biru tua Primakara
                        'primakara-blue-hover': '#081E50', // Biru lebih gelap untuk hover
                        'primakara-light': '#E9F1FF', // Biru sangat muda / abu-abu kebiruan
                        'primakara-gray': '#F5F7FA', // Abu-abu muda untuk background
                        'primakara-dark-gray': '#334155', // Abu-abu tua untuk teks utama
                        'primakara-medium-gray': '#64748B', // Abu-abu sedang untuk teks sekunder
                        'primakara-border-gray': '#CBD5E1', // Abu-abu untuk border
                    }
                }
            },
            plugins: [
                function({
                    addComponents
                }) {
                    addComponents({
                        '.nav-link': {
                            color: '#334155',
                            fontWeight: '500',
                            transition: 'color 300ms',
                            '&:hover': {
                                color: '#0A2463'
                            }
                        },
                        '.nav-link-mobile': {
                            display: 'block',
                            padding: '0.5rem 1rem',
                            fontSize: '0.875rem',
                            color: '#334155',
                            transition: 'all 300ms',
                            '&:hover': {
                                backgroundColor: '#E9F1FF',
                                color: '#0A2463'
                            }
                        },
                        '.btn-primary': {
                            backgroundColor: '#0A2463',
                            color: 'white',
                            padding: '0.625rem 1.5rem',
                            borderRadius: '0.375rem',
                            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                            transition: 'all 300ms',
                            '&:hover': {
                                backgroundColor: '#081E50'
                            }
                        },
                        '.btn-secondary': {
                            borderWidth: '2px',
                            borderColor: 'white',
                            color: 'white',
                            padding: '0.625rem 1.5rem',
                            borderRadius: '0.375rem',
                            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                            transition: 'all 300ms',
                            '&:hover': {
                                backgroundColor: 'white',
                                color: '#0A2463'
                            }
                        },
                        '.btn-outline': {
                            borderWidth: '1px',
                            borderColor: '#0A2463',
                            color: '#0A2463',
                            padding: '0.625rem 1.5rem',
                            borderRadius: '0.375rem',
                            transition: 'all 300ms',
                            '&:hover': {
                                backgroundColor: '#0A2463',
                                color: 'white'
                            }
                        },
                        '.feature-card': {
                            backgroundColor: 'white',
                            padding: '1.5rem',
                            borderRadius: '0.75rem',
                            boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                            transition: 'all 300ms',
                            '&:hover': {
                                boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                                transform: 'translateY(-0.5rem)'
                            }
                        },
                        '.feature-card-icon-bg': {
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '3.5rem',
                            height: '3.5rem',
                            backgroundColor: '#E9F1FF',
                            borderRadius: '9999px',
                            color: '#0A2463',
                            marginBottom: '1.25rem'
                        },
                        '.section-title': {
                            fontFamily: "'Poppins', sans-serif",
                            fontSize: '1.875rem',
                            fontWeight: '700',
                            color: '#0A2463',
                            marginBottom: '1rem',
                            '@screen md': {
                                fontSize: '2.25rem'
                            }
                        },
                        '.section-subtitle': {
                            color: '#64748B',
                            fontSize: '1.125rem',
                            maxWidth: '42rem',
                            marginLeft: 'auto',
                            marginRight: 'auto'
                        },
                        '.w-layout': {
                            width: '85%',
                            marginLeft: 'auto',
                            marginRight: 'auto',
                            paddingLeft: '1rem',
                            paddingRight: '1rem',
                            '@screen md': {
                                width: '80%'
                            }
                        }
                    })
                }
            ]
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #334155;
        }

        .font-display {
            font-family: 'Poppins', sans-serif;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0A2463;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: #64748B;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .feature-card a {
            color: #0A2463;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
        }

        .feature-card a:hover {
            color: #081E50;
        }
    </style>
</head>

<body class="bg-primakara-gray">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="w-layout py-4 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="https://sidos.primakara.ac.id//assets/img/new-primakara-crop.png"
                    alt="Logo Universitas Primakara" class="h-10 md:h-12">
            </a>
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="" class="nav-link">Beranda</a>
                <a href="" class="nav-link">Fitur Portal</a>
                <a href="" class="nav-link">UKM</a>
                <a href="" class="nav-link">TAK</a>
            </nav>
            <div class="hidden lg:flex items-center space-x-3">
                <a href="/login" class="btn-primary text-sm px-5 py-2">Masuk</a>
            </div>
            <div class="lg:hidden">
                <button id="mobile-menu-button" class="text-primakara-blue focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white shadow-lg border-t border-primakara-light">
            <a href="" class="nav-link-mobile">Beranda</a>
            <a href="" class="nav-link-mobile">Fitur Portal</a>
            <a href="" class="nav-link-mobile">UKM</a>
            <a href="" class="nav-link-mobile">TAK</a>
            <div class="p-4 border-t border-primakara-light">
                <a href="/login" class="block w-full text-center btn-primary mb-2">Masuk</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="relative bg-white overflow-hidden">
        <!-- Background elements -->
        <div class="absolute top-0 right-0 -mr-40 -mt-40 w-80 h-80 bg-primakara-light rounded-full opacity-50"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-64 h-64 bg-primakara-light rounded-full opacity-30"></div>

        <!-- Content -->
        <div class="w-layout relative z-10 py-24 md:py-32 lg:py-40">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-left">
                    <div
                        class="inline-flex items-center px-4 py-1 rounded-full bg-primakara-light text-primakara-blue text-sm font-medium mb-6">
                        <span class="inline-block w-2 h-2 rounded-full bg-primakara-blue mr-2"></span>
                        <span>Portal Mahasiswa Primakara</span>
                    </div>

                    <h1 class="font-sans text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 text-primakara-dark-gray">
                        Portal Aktivitas <span class="text-primakara-blue">Mahasiswa</span>
                    </h1>

                    <h2 class="font-sans text-3xl sm:text-4xl font-bold mb-6 text-primakara-dark-gray">
                        Universitas Primakara
                    </h2>

                    <p class="text-lg mb-10 text-primakara-medium-gray max-w-xl">
                        Dari Aktivitas Jadi Prestasi. Wujudkan Impianmu di Primakara.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/register"
                            class="bg-primakara-blue hover:bg-primakara-blue-hover text-white font-medium px-6 py-3 rounded-lg transition-all duration-300 text-center shadow-lg hover:shadow-primakara-blue/30">
                            Daftar Sekarang
                        </a>
                        <a href="#fitur"
                            class="border-2 border-primakara-blue text-primakara-blue hover:bg-primakara-blue hover:text-white font-medium px-6 py-3 rounded-lg transition-all duration-300 text-center">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <!-- Image/Graphics -->
                <div class="hidden lg:block relative">
                    <div class="relative">
                        <div class="absolute -top-10 -right-10 w-20 h-20 bg-primakara-light rounded-full"></div>

                        <!-- Primary Image -->
                        <img src="https://dashboard.primakara.ac.id/uploads/Foto_Gedung_Primakara_University_13dee9a554.jpg"
                            alt="Gedung Primakara University"
                            class="rounded-2xl shadow-xl w-full h-[400px] object-cover z-10 relative">

                        <!-- Floating Elements -->
                        <div
                            class="absolute top-12 -left-8 bg-white p-4 rounded-xl shadow-lg z-20 flex gap-3 items-center">
                            <div
                                class="w-10 h-10 bg-primakara-light rounded-full flex items-center justify-center text-primakara-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-primakara-dark-gray">Akses Cepat</div>
                                <div class="text-xs text-primakara-medium-gray">portal kemahasiswaan</div>
                            </div>
                        </div>

                        <div class="absolute -bottom-5 right-10 bg-white p-4 rounded-xl shadow-lg z-20">
                            <div class="flex gap-3 items-center">
                                <div
                                    class="w-10 h-10 bg-primakara-light rounded-full flex items-center justify-center text-primakara-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-primakara-dark-gray">TAK & UKM</div>
                                    <div class="text-xs text-primakara-medium-gray">dalam satu portal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Fitur Section -->
    <section id="fitur" class="py-16 md:py-24">
        <div class="w-layout">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="section-title">Fitur Unggulan Portal</h2>
                <p class="section-subtitle">Dirancang untuk mendukung setiap langkah perjalanan kemahasiswaan Anda di
                    Universitas Primakara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Dasbor Mahasiswa -->
                <div class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3>Dasbor Mahasiswa</h3>
                    <p>Akses cepat informasi pribadi, jadwal, notifikasi, dan ringkasan aktivitas Anda.</p>
                    <a href="{{ route("dashboard.index") }}">Buka Dasbor &rarr;</a>
                </div>

                <!-- Profil Mahasiswa -->
                <div class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3>Profil Mahasiswa</h3>
                    <p>Lihat profil Anda atau mahasiswa lain. URL: `/profile` atau `/profile/{id_mahasiswa}`.</p>
                    <a href="{{ route("users.profile") }}">Lihat Profil &rarr;</a>
                </div>

                <!-- Kegiatan UKM -->
                <div id="ukm" class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3>Kegiatan UKM</h3>
                    <p>Temukan daftar kegiatan UKM terbaru dan lihat detail setiap acara.</p>
                    <a href="/ukm/kegiatan">Jelajahi Kegiatan &rarr;</a>
                </div>

                <!-- Riwayat & Leaderboard TAK -->
                <div id="tak" class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3>Transkrip Aktivitas (TAK)</h3>
                    <p>Pantau riwayat TAK Anda dan lihat posisi di leaderboard (filter per angkatan).</p>
                    <a href="/tak/riwayat" class="mr-4">Riwayat TAK &rarr;</a>
                    <a href="/tak/leaderboard">Leaderboard &rarr;</a>
                </div>

                <!-- Pengajuan Pembina UKM -->
                <div class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4" />
                        </svg>
                    </div>
                    <h3>Pengajuan Pembina UKM</h3>
                    <p>Daftarkan diri Anda untuk menjadi pembina UKM dan berkontribusi lebih.</p>
                    <a href="/ukm/pengajuan-pembina">Ajukan Sekarang &rarr;</a>
                </div>

                <!-- Bergabung UKM -->
                <div class="feature-card">
                    <div class="feature-card-icon-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3>Gabung UKM</h3>
                    <p>Temukan dan bergabunglah dengan Unit Kegiatan Mahasiswa yang sesuai minat Anda.</p>
                    <a href="/ukm/daftar">Lihat Daftar UKM &rarr;</a>
                </div>
            </div>
        </div>
    </section>


<!-- Leaderboard Section -->
<section id="leaderboard" class="py-16 md:py-24 bg-white relative">
    <!-- Wave Pattern Top -->
    <div class="absolute top-0 left-0 right-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" class="fill-primakara-gray w-full h-12">
            <path d="M0,0L60,8C120,16,240,32,360,32C480,32,600,16,720,16C840,16,960,32,1080,32C1200,32,1320,16,1380,8L1440,0L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
        </svg>
    </div>

    <div class="w-layout">
        <div class="text-center mb-12">
            <h2 class="section-title">Leaderboard TAK</h2>
            <p class="section-subtitle">Mahasiswa dengan poin Transkrip Aktivitas Kemahasiswaan tertinggi semester ini. Jadilah yang terbaik!</p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button class="bg-primakara-blue text-white px-4 py-2 rounded-md text-sm font-medium">Semua Angkatan</button>
            <button class="bg-primakara-light text-primakara-blue px-4 py-2 rounded-md text-sm font-medium hover:bg-primakara-blue/10 transition">Angkatan 2023</button>
            <button class="bg-primakara-light text-primakara-blue px-4 py-2 rounded-md text-sm font-medium hover:bg-primakara-blue/10 transition">Angkatan 2022</button>
            <button class="bg-primakara-light text-primakara-blue px-4 py-2 rounded-md text-sm font-medium hover:bg-primakara-blue/10 transition">Angkatan 2021</button>
            <button class="bg-primakara-light text-primakara-blue px-4 py-2 rounded-md text-sm font-medium hover:bg-primakara-blue/10 transition">Angkatan 2020</button>
        </div>

        <!-- Top 3 Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- 2nd Place -->
            <div class="flex flex-col items-center transform md:translate-y-8">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden border-4 border-primakara-light mb-3">
                    <img src="https://i.pravatar.cc/200?img=32" alt="Runner Up" class="w-full h-full object-cover">
                </div>
                <div class="bg-white rounded-xl shadow-lg p-5 text-center w-full">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 mb-3">
                        <span class="text-lg font-bold text-primakara-medium-gray">2</span>
                    </div>
                    <h3 class="font-bold text-primakara-dark-gray text-lg">Putu Aditya</h3>
                    <p class="text-sm text-primakara-medium-gray mb-2">Teknik Informatika</p>
                    <div class="text-primakara-blue font-bold text-xl">192 Poin</div>
                </div>
            </div>

            <!-- 1st Place -->
            <div class="flex flex-col items-center">
                <div class="relative mb-4">
                    <svg class="w-12 h-12 text-yellow-500 absolute -top-6 left-1/2 transform -translate-x-1/2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-yellow-400 mb-3">
                    <img src="https://i.pravatar.cc/200?img=25" alt="Winner" class="w-full h-full object-cover">
                </div>
                <div class="bg-primakara-blue text-white rounded-xl shadow-lg p-5 text-center w-full">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primakara-blue-hover mb-3 border-2 border-white/30">
                        <span class="text-lg font-bold">1</span>
                    </div>
                    <h3 class="font-bold text-white text-xl">Kadek Surya</h3>
                    <p class="text-sm text-white/80 mb-2">Sistem Informasi Bisnis</p>
                    <div class="text-white font-bold text-2xl">234 Poin</div>
                </div>
            </div>

            <!-- 3rd Place -->
            <div class="flex flex-col items-center transform md:translate-y-12">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden border-4 border-primakara-light mb-3">
                    <img src="https://i.pravatar.cc/200?img=44" alt="Third Place" class="w-full h-full object-cover">
                </div>
                <div class="bg-white rounded-xl shadow-lg p-5 text-center w-full">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 mb-3">
                        <span class="text-lg font-bold text-primakara-medium-gray">3</span>
                    </div>
                    <h3 class="font-bold text-primakara-dark-gray text-lg">Ni Made Devi</h3>
                    <p class="text-sm text-primakara-medium-gray mb-2">Desain Komunikasi Visual</p>
                    <div class="text-primakara-blue font-bold text-xl">175 Poin</div>
                </div>
            </div>
        </div>

        <!-- Table Rankings -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Headers -->
            <div class="bg-primakara-blue text-white py-4 px-6 hidden md:grid grid-cols-12 gap-4">
                <div class="col-span-1 font-medium text-center">Rank</div>
                <div class="col-span-6 font-medium">Nama</div>
                <div class="col-span-3 font-medium">Program Studi</div>
                <div class="col-span-2 font-medium text-right">Poin TAK</div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-primakara-light">
                <!-- Row 4 -->
                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-center hover:bg-primakara-gray/30 transition">
                    <div class="flex md:block col-span-1 text-center font-medium text-primakara-medium-gray">
                        <span class="inline-block w-8 md:w-auto md:mb-0 mr-3 md:mr-0">4</span>
                        <img src="https://i.pravatar.cc/200?img=12" alt="" class="md:hidden w-10 h-10 rounded-full mr-3">
                    </div>
                    <div class="flex items-center md:col-span-6">
                        <img src="https://i.pravatar.cc/200?img=12" alt="" class="hidden md:block w-10 h-10 rounded-full mr-3">
                        <span class="font-medium text-primakara-dark-gray">I Nyoman Wijaya</span>
                    </div>
                    <div class="col-span-3 text-primakara-medium-gray text-sm md:text-base">Bisnis Digital</div>
                    <div class="col-span-2 text-right font-bold text-primakara-blue">162 Poin</div>
                </div>

                <!-- Row 5 -->
                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-center hover:bg-primakara-gray/30 transition">
                    <div class="flex md:block col-span-1 text-center font-medium text-primakara-medium-gray">
                        <span class="inline-block w-8 md:w-auto md:mb-0 mr-3 md:mr-0">5</span>
                        <img src="https://i.pravatar.cc/200?img=28" alt="" class="md:hidden w-10 h-10 rounded-full mr-3">
                    </div>
                    <div class="flex items-center md:col-span-6">
                        <img src="https://i.pravatar.cc/200?img=28" alt="" class="hidden md:block w-10 h-10 rounded-full mr-3">
                        <span class="font-medium text-primakara-dark-gray">Komang Ayu Pradnya</span>
                    </div>
                    <div class="col-span-3 text-primakara-medium-gray text-sm md:text-base">Teknik Informatika</div>
                    <div class="col-span-2 text-right font-bold text-primakara-blue">154 Poin</div>
                </div>

                <!-- Row 6 -->
                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-center hover:bg-primakara-gray/30 transition">
                    <div class="flex md:block col-span-1 text-center font-medium text-primakara-medium-gray">
                        <span class="inline-block w-8 md:w-auto md:mb-0 mr-3 md:mr-0">6</span>
                        <img src="https://i.pravatar.cc/200?img=65" alt="" class="md:hidden w-10 h-10 rounded-full mr-3">
                    </div>
                    <div class="flex items-center md:col-span-6">
                        <img src="https://i.pravatar.cc/200?img=65" alt="" class="hidden md:block w-10 h-10 rounded-full mr-3">
                        <span class="font-medium text-primakara-dark-gray">Made Rai Aditya</span>
                    </div>
                    <div class="col-span-3 text-primakara-medium-gray text-sm md:text-base">Sistem Informasi Bisnis</div>
                    <div class="col-span-2 text-right font-bold text-primakara-blue">149 Poin</div>
                </div>

                <!-- Row 7 -->
                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-4 items-center hover:bg-primakara-gray/30 transition">
                    <div class="flex md:block col-span-1 text-center font-medium text-primakara-medium-gray">
                        <span class="inline-block w-8 md:w-auto md:mb-0 mr-3 md:mr-0">7</span>
                        <img src="https://i.pravatar.cc/200?img=37" alt="" class="md:hidden w-10 h-10 rounded-full mr-3">
                    </div>
                    <div class="flex items-center md:col-span-6">
                        <img src="https://i.pravatar.cc/200?img=37" alt="" class="hidden md:block w-10 h-10 rounded-full mr-3">
                        <span class="font-medium text-primakara-dark-gray">Wayan Sukma Adi</span>
                    </div>
                    <div class="col-span-3 text-primakara-medium-gray text-sm md:text-base">Desain Komunikasi Visual</div>
                    <div class="col-span-2 text-right font-bold text-primakara-blue">132 Poin</div>
                </div>
            </div>
        </div>

        <!-- Button to View Full Leaderboard -->
        <div class="mt-8 text-center">
            <a href="/tak/leaderboard" class="inline-block border-2 border-primakara-blue text-primakara-blue hover:bg-primakara-blue hover:text-white font-medium px-6 py-3 rounded-lg transition-all duration-300 text-center">
                Lihat Leaderboard Lengkap
            </a>
        </div>
    </div>
</section>

    <!-- Call to Action Section -->
    <section class="bg-primakara-light py-20 md:py-28 relative overflow-hidden">
        <!-- Background Decorative Elements -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-primakara-blue opacity-5 rounded-full transform translate-x-1/3 -translate-y-1/4">
        </div>
        <div
            class="absolute bottom-0 left-0 w-48 h-48 bg-primakara-blue opacity-5 rounded-full transform -translate-x-1/3 translate-y-1/4">
        </div>

        <div class="w-layout text-center relative z-10">
            <h2 class="text-primakara-blue text-4xl md:text-5xl font-bold mb-6">
                Siap Mengembangkan Diri di Primakara?
            </h2>

            <p class="text-primakara-medium-gray text-lg md:text-xl max-w-3xl mx-auto mb-12 leading-relaxed">
                Jangan lewatkan kesempatan untuk aktif, berprestasi, dan membangun jaringan. Daftar atau masuk sekarang
                untuk memulai!
            </p>

            <a href="/register"
                class="inline-block bg-primakara-blue hover:bg-primakara-blue-hover text-white font-medium px-10 py-4 rounded-lg text-lg transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Buat Akun Mahasiswa Anda
            </a>
        </div>

        <div class="absolute top-0 left-0 right-0 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 48" class="fill-white w-full h-12">
                <path
                    d="M0,0L60,8C120,16,240,32,360,32C480,32,600,16,720,16C840,16,960,32,1080,32C1200,32,1320,16,1380,8L1440,0L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primakara-blue text-primakara-light py-12">
        <div class="w-layout">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div>
                    <h2 class="font-sans text-white text-2xl font-bold tracking-wide mb-4">PRIMAKARA UNIVERSITY</h2>
                    <p class="text-sm opacity-80">Jl. Tukad Badung No.135, Renon, Denpasar Selatan, Kota Denpasar, Bali
                        80226</p>
                    <p class="text-sm mt-2 opacity-80">Email: <a href="mailto:info@primakara.ac.id"
                            class="hover:text-white transition-colors">info@primakara.ac.id</a></p>
                </div>
                <div>
                    <h5 class="font-sans font-semibold text-white text-lg mb-4">Tautan Portal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#hero"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Beranda</a>
                        </li>
                        <li><a href="#fitur"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Fitur
                                Portal</a></li>
                        <li><a href="#ukm"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Kegiatan
                                UKM</a></li>
                        <li><a href="#tak"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Informasi
                                TAK</a></li>
                        <li><a href="/login"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Masuk</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-sans font-semibold text-white text-lg mb-4">Tautan Universitas</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://primakara.ac.id" target="_blank"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Website Utama
                                Primakara</a></li>
                        <li><a href="https://baak.primakara.ac.id" target="_blank"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">BAAK
                                Primakara</a></li>
                        <li><a href="https://library.primakara.ac.id" target="_blank"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Perpustakaan</a>
                        </li>
                        <li><a href="#"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Kebijakan
                                Privasi</a></li>
                        <li><a href="#"
                                class="opacity-80 hover:opacity-100 hover:text-white transition-colors">Syarat &
                                Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-sans font-semibold text-white text-lg mb-4">Media Sosial</h5>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/primakara.ac.id/" target="_blank"
                            class="text-primakara-light hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/primakara.university/" target="_blank"
                            class="text-primakara-light hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919C8.416 2.175 8.796 2.163 12 2.163m0-2.163C8.74.001 8.333.015 7.053.072c-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.668.072 4.948c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.668-.014 4.948-.072c4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.196-4.354-2.617-6.78-6.979-6.98C15.668.015 15.26.001 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/channel/UCc0csi0y5qL0o9x2Qk5g99g" target="_blank"
                            class="text-primakara-light hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-700 pt-8 text-center text-sm">
                <p class="opacity-80">&copy; <span id="currentYear"></span> Universitas Primakara. Hak Cipta
                    Dilindungi.</p>
                <p class="opacity-80">Portal Aktivitas Mahasiswa dikelola oleh Kemahasiswaan Universitas Primakara.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelectorAll('.nav-link-mobile, .nav-link');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (!mobileMenu.classList.contains('hidden')) {
                    if (link.getAttribute('href').startsWith('#')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>
