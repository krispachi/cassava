<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Cassava</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primakara-blue': '#0A2463',
                        'primakara-blue-hover': '#081E50',
                        'primakara-light': '#E9F1FF',
                        'primakara-gray': '#F5F7FA',
                        'primakara-dark-gray': '#334155',
                        'primakara-medium-gray': '#64748B',
                        'primakara-border-gray': '#CBD5E1',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-primakara-gray font-sans">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl">
            <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Left Column - Image & Info -->
                <div class="lg:w-1/2 relative bg-primakara-blue overflow-hidden">
                    <!-- Background Image -->
                    <div class="absolute inset-0">
                        <img src="https://dashboard.primakara.ac.id/uploads/Foto_Gedung_Primakara_University_13dee9a554.jpg"
                            alt="Gedung Primakara University" class="w-full h-full object-cover opacity-20">
                    </div>

                    <!-- Content -->
                    <div class="relative p-12 flex flex-col h-full">
                        <!-- Logo in white box -->
                        <div class="bg-white p-4 rounded-xl shadow-md inline-block mb-8 self-start">
                            <img src="{{ asset("images/primakara-logo.png") }}"
                                alt="Logo Primakara University" class="h-8">
                        </div>

                        <div class="flex-grow">
                            <h2 class="text-3xl font-bold text-white mb-6">
                                Selamat Datang di Portal<br>Aktivitas Mahasiswa
                            </h2>

                            <p class="text-primakara-light/80 leading-relaxed mb-8">
                                Masuk untuk mengakses fitur-fitur portal seperti manajemen TAK, kegiatan UKM, dan
                                informasi kemahasiswaan lainnya.
                            </p>

                            <!-- Features List -->
                            <div class="space-y-4">
                                <div class="flex items-center text-white/90">
                                    <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
                                    <span>Manajemen Transkrip Aktivitas Kemahasiswaan</span>
                                </div>
                                <div class="flex items-center text-white/90">
                                    <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
                                    <span>Informasi dan Pendaftaran Kegiatan UKM</span>
                                </div>
                                <div class="flex items-center text-white/90">
                                    <i class="bi bi-check-circle-fill mr-3 text-xl"></i>
                                    <span>Dashboard Personalisasi untuk Mahasiswa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Login Form -->
                <div class="lg:w-1/2 p-12">
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-primakara-dark-gray">
                                Masuk ke CASSAVA
                            </h3>
                            <p class="text-primakara-medium-gray mt-2">
                                Masukkan email dan password Anda
                            </p>
                        </div>

                        <form class="space-y-6" action="{{ route('login') }}" method="post">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-primakara-dark-gray mb-2">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bi bi-envelope text-primakara-medium-gray"></i>
                                    </div>
                                    <input id="email" name="email" type="email" required
                                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-primakara-border-gray focus:ring-2 focus:ring-primakara-blue focus:border-transparent @error('email') border-red-500 @enderror"
                                        placeholder="nama@student.primakara.ac.id" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-primakara-dark-gray mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bi bi-lock text-primakara-medium-gray"></i>
                                    </div>
                                    <input id="password" name="password" type="password" required
                                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-primakara-border-gray focus:ring-2 focus:ring-primakara-blue focus:border-transparent @error('password') border-red-500 @enderror"
                                        placeholder="Masukkan password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me and Forgot Password-->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox"
                                        class="h-4 w-4 text-primakara-blue focus:ring-primakara-blue border-primakara-border-gray rounded"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="ml-2 block text-sm text-primakara-medium-gray">
                                        Ingat saya
                                    </label>
                                </div>
                                <div>
                                    <a href=""
                                        class="text-sm text-primakara-blue hover:text-primakara-blue-hover transition-colors">
                                        Lupa password?
                                    </a>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg text-white bg-primakara-blue hover:bg-primakara-blue-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primakara-blue transition duration-150 ease-in-out">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Masuk</span>
                            </button>
                        </form>

                        <!-- Back to Home -->
                        <div class="mt-8 text-center">
                            <a href="/"
                                class="inline-flex items-center text-sm text-primakara-medium-gray hover:text-primakara-blue transition-colors">
                                <i class="bi bi-arrow-left mr-2"></i>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
