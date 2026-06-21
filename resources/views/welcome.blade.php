<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Aduan - BLU Trans Semarang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <div class="relative flex items-center justify-center min-h-screen bg-white overflow-hidden selection:bg-blue-500 selection:text-white">
        
        <div class="absolute inset-0 bg-[url('https://laravel.com/assets/img/welcome/background.svg')] bg-center bg-cover bg-no-repeat opacity-10"></div>

        <div class="relative max-w-4xl mx-auto px-6 py-16 text-center">
            
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-blue-900 mb-6">
                Layanan Pengaduan & Aspirasi <br>
                <span class="text-blue-600">BLU Trans Semarang</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto">
                Sampaikan keluhan, saran, maupun apresiasi Anda terkait fasilitas halte, pelayanan pengemudi, hingga kondisi armada kami. Laporan Anda sangat berarti untuk perbaikan layanan transportasi publik Kota Semarang.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300">
                            Masuk ke Ruang Kerja Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 w-full sm:w-auto">
                            Masuk / Buat Laporan
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold rounded-lg shadow-sm transition duration-300 w-full sm:w-auto">
                                Daftar Akun Baru
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="mt-16 text-sm text-gray-500">
                &copy; {{ date('Y') }} BLU Trans Semarang. Semua hak cipta dilindungi.
            </div>
        </div>
    </div>
</body>
</html>