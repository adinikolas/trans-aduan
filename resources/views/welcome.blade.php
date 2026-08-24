<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Lapor Trans Semarang') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 selection:bg-red-600 selection:text-white font-sans">

    <!-- NAVBAR ATAS -->
    <nav class="relative z-10 w-full px-6 py-4 flex justify-between items-center bg-white dark:bg-gray-800 shadow-sm border-b border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <!-- LOGO BARU DIMASUKKAN DI SINI -->
            <img src="{{ asset('images/trans smg.png') }}" alt="Logo Trans Semarang" class="h-10 w-10 rounded-md object-cover shadow-sm">
            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Trans Semarang</span>
        </div>

        <div>
            @if (Route::has('login'))
                <!-- DITAMBAHKAN items-center AGAR TOMBOL MASUK SEJAJAR -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition">Dashboard Saya &rarr;</a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition"
                        >
                            Login Pengguna
                        </a>

                        <a
                            href="{{ route('internal.login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition"
                        >
                            Login Internal
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="font-semibold px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-800 transition shadow-sm"
                            >
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-12 space-y-20">

        <!-- 1. HERO SECTION -->
        <div class="text-center max-w-3xl mx-auto pt-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-6">
                Transportasi Massal Andalan <span class="text-red-700 dark:text-red-500">Kota Semarang</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                Bus Rapid Transit (BRT) Trans Semarang hadir sebagai pionir transportasi darat yang nyaman, aman, cepat, dan murah untuk menunjang tingginya mobilitas masyarakat. Sampaikan apresiasi dan keluhan Anda demi layanan yang lebih baik.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-red-700 text-white font-bold rounded-lg hover:bg-red-800 shadow-md transition transform hover:-translate-y-0.5">
                    + Buat Laporan Sekarang
                </a>
                <a href="#informasi" class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-bold rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                    Pelajari Layanan
                </a>
            </div>
        </div>

        <!-- 2. FITUR & KEUNGGULAN (KOMITMEN 3A) -->
        <div id="informasi" class="pt-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Visi Kami: Profesional & Dapat Diandalkan</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Berkomitmen penuh memberikan pelayanan terbaik berstandar tinggi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-md transition">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">💰</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sangat Terjangkau</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Harga tiket disubsidi 80% oleh Pemerintah Kota Semarang. Cukup bayar satu kali untuk rute jauh maupun dekat.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-md transition">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">❄️</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Kenyamanan Maksimal</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Menggunakan armada bus AC dengan kepastian waktu tunggu penumpang yang dapat diandalkan.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-md transition">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">🛡️</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Keamanan Terjamin</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Pengguna jasa Bus Rapid Transit Trans Semarang memperoleh rasa aman dari segala gangguan selama perjalanan.</p>
                </div>
            </div>
        </div>

        <!-- 3. TARIF & OPERASIONAL -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start bg-white dark:bg-gray-800 p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">

            <!-- Tarif -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informasi Harga Tiket</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Tiket Umum (Tunai)</span>
                        <span class="font-extrabold text-lg text-gray-900 dark:text-white">Rp 4.000,- <span class="text-xs font-normal text-gray-500"></span></span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg">
                        <span class="font-medium text-red-700 dark:text-red-400">Tiket Umum (Cashless) <span class="ml-2 text-xs bg-red-200 dark:bg-red-800 text-red-900 dark:text-red-100 px-2 py-0.5 rounded">Lebih Hemat</span></span>
                        <span class="font-extrabold text-lg text-red-700 dark:text-red-400">Rp 3.500,- <span class="text-xs font-normal opacity-70"></span></span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Tiket Khusus</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Pelajar, Mahasiswa, Lansia, Veteran, KIA & Disabilitas</span>
                        </div>
                        <span class="font-extrabold text-lg text-gray-900 dark:text-white">Rp 1.000,- <span class="text-xs font-normal text-gray-500"></span></span>
                    </div>
                </div>
            </div>

            <!-- Jam & Rute -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Waktu Operasional</h2>
                <ul class="space-y-6 relative border-l-2 border-gray-200 dark:border-gray-700 ml-3">
                    <li class="pl-6 relative">
                        <div class="absolute w-4 h-4 bg-red-600 rounded-full -left-[9px] top-1 border-4 border-white dark:border-gray-800"></div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Layanan Reguler (Koridor 1 - Feeder 4)</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Beroperasi setiap hari mulai pukul <span class="font-semibold">05.30 WIB - 18.30 WIB</span>.</p>
                    </li>
                    <li class="pl-6 relative">
                        <div class="absolute w-4 h-4 bg-yellow-500 rounded-full -left-[9px] top-1 border-4 border-white dark:border-gray-800"></div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Layanan Mangkang Malam</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Terminal Mangkang - Simpang Lima, beroperasi pukul <span class="font-semibold">17.30 WIB - 23.30 WIB</span>.</p>
                    </li>
                </ul>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-20 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} BLU UPTD Trans Semarang. Semua hak cipta dilindungi. <br>
            Layanan Pengaduan & Aspirasi Masyarakat.
        </div>
    </footer>

</body>
</html>
