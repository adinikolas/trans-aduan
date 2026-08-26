<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Aduan Trans Semarang</title>

    {{-- APPLY THEME BEFORE PAGE RENDERS --}}
    <script>
        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (
            savedTheme === 'dark' ||
            (!savedTheme && systemDark)
        ) {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body
    x-data="{
        open: false,
        loginModal: false
    }"
    @keydown.escape.window="loginModal = false"
    class="bg-slate-100 text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-white"
>

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}
    <nav
        class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur dark:border-slate-800 dark:bg-slate-950/95"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                {{-- LOGO --}}
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center">
                        <x-application-logo class="h-10 w-10" />
                    </div>

                    <div class="hidden sm:block">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">
                            Trans Semarang
                        </div>

                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Sistem Aduan
                        </div>
                    </div>
                </div>

                {{-- DESKTOP NAVIGATION --}}
                <div class="hidden items-center gap-5 md:flex">

                    <a
                        href="#beranda"
                        class="text-sm text-slate-600 transition duration-200 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Beranda
                    </a>

                    <a
                        href="#tentang"
                        class="text-sm text-slate-600 transition duration-200 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Tentang
                    </a>

                    <a
                        href="#alur"
                        class="text-sm text-slate-600 transition duration-200 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Alur Aduan
                    </a>

                    {{-- THEME --}}
                    <x-theme-toggle />

                    {{-- LOGIN --}}
                    <button
                        type="button"
                        @click="loginModal = true"
                        class="rounded-lg bg-[#C8102E] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition duration-200 hover:bg-[#A50D25] hover:shadow-[#C8102E]/40 active:scale-95"
                    >
                        Masuk Sistem
                    </button>
                </div>

                {{-- MOBILE MENU BUTTON --}}
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-slate-600 transition duration-200 hover:bg-[#C8102E]/10 hover:text-[#C8102E] dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white md:hidden"
                    aria-label="Toggle navigation"
                >
                    {{-- HAMBURGER --}}
                    <svg
                        x-show="!open"
                        x-cloak
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                    {{-- CLOSE --}}
                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            {{-- MOBILE NAVIGATION --}}
            <div
                x-show="open"
                x-cloak
                x-transition
                class="border-t border-slate-200 py-4 dark:border-slate-800 md:hidden"
            >
                <div class="flex flex-col gap-2">

                    <a
                        href="#beranda"
                        @click="open = false"
                        class="rounded-lg px-4 py-3 text-sm text-slate-600 transition duration-200 hover:bg-[#C8102E]/10 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Beranda
                    </a>

                    <a
                        href="#tentang"
                        @click="open = false"
                        class="rounded-lg px-4 py-3 text-sm text-slate-600 transition duration-200 hover:bg-[#C8102E]/10 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Tentang
                    </a>

                    <a
                        href="#alur"
                        @click="open = false"
                        class="rounded-lg px-4 py-3 text-sm text-slate-600 transition duration-200 hover:bg-[#C8102E]/10 hover:text-[#C8102E] dark:text-slate-300"
                    >
                        Alur Aduan
                    </a>

                    {{-- MOBILE THEME --}}
                    <div
                        class="mt-2 flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-800 dark:bg-slate-900/50"
                    >
                        <span class="text-sm text-slate-600 dark:text-slate-300">
                            Tampilan
                        </span>

                        <x-theme-toggle />
                    </div>

                    {{-- MOBILE LOGIN --}}
                    <button
                        type="button"
                        @click="open = false; loginModal = true"
                        class="mt-2 rounded-lg bg-[#C8102E] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition duration-200 hover:bg-[#A50D25] hover:shadow-[#C8102E]/40 active:scale-95"
                    >
                        Masuk Sistem
                    </button>
                </div>
            </div>
        </div>
    </nav>


    {{-- =========================================================
         HERO
    ========================================================== --}}
    <main id="beranda">

        <section class="relative overflow-hidden">

            {{-- BACKGROUND GLOW --}}
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute left-1/2 top-0 h-96 w-96 -translate-x-1/2 rounded-full bg-[#C8102E]/10 blur-3xl"
                ></div>

                <div
                    class="absolute right-0 top-1/3 h-72 w-72 rounded-full bg-[#C8102E]/10 blur-3xl"
                ></div>

                <div
                    class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-[#A50D25]/10 blur-3xl"
                ></div>
            </div>

            <div
                class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8 lg:py-32"
            >
                <div class="mx-auto max-w-4xl text-center">

                    {{-- BADGE --}}
                    <div
                        class="mb-6 inline-flex items-center rounded-full border border-[#C8102E]/30 bg-[#C8102E]/10 px-4 py-2 text-xs font-medium text-[#C8102E] dark:text-red-300"
                    >
                        Sistem Informasi Aduan Trans Semarang
                    </div>

                    {{-- HEADING --}}
                    <h1
                        class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl dark:text-white"
                    >
                        Sampaikan Aduan,

                        <span class="text-[#C8102E]">
                            Tingkatkan Pelayanan
                        </span>
                    </h1>

                    {{-- DESCRIPTION --}}
                    <p
                        class="mx-auto mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8 dark:text-slate-400"
                    >
                        Laporkan kendala, keluhan, maupun permasalahan
                        terkait layanan Trans Semarang dengan mudah dan
                        pantau proses penanganannya melalui satu sistem.
                    </p>

                    {{-- CTA --}}
                    <div
                        class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center"
                    >

                        {{-- LOGIN --}}
                        <button
                            type="button"
                            @click="loginModal = true"
                            class="rounded-xl bg-[#C8102E] px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition duration-200 hover:bg-[#A50D25] hover:shadow-[#C8102E]/40 active:scale-95"
                        >
                            Masuk ke Sistem
                        </button>

                        {{-- ALUR --}}
                        <a
                            href="#alur"
                            class="rounded-xl border border-slate-300 bg-white px-7 py-3.5 text-center text-sm font-semibold text-slate-700 transition duration-200 hover:border-[#C8102E]/50 hover:bg-[#C8102E]/5 hover:text-[#C8102E] active:scale-95 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white"
                        >
                            Lihat Alur Aduan
                        </a>
                    </div>
                </div>
            </div>
        </section>


        {{-- =====================================================
             TENTANG
        ====================================================== --}}
        <section
            id="tentang"
            class="border-t border-slate-200 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-900/50"
        >
            <div
                class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8"
            >
                <div class="mx-auto max-w-2xl text-center">

                    <h2
                        class="text-2xl font-bold text-slate-900 sm:text-3xl dark:text-white"
                    >
                        Sistem Aduan Terintegrasi
                    </h2>

                    <p
                        class="mt-4 text-sm leading-6 text-slate-600 sm:text-base dark:text-slate-400"
                    >
                        Setiap aduan akan diteruskan kepada divisi yang
                        sesuai berdasarkan jenis permasalahan yang dilaporkan.
                    </p>
                </div>

                {{-- CARDS --}}
                <div class="mt-10 grid gap-6 md:grid-cols-3">

                    {{-- CARD 1 --}}
                    <div
                        class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-[#C8102E]/40 hover:shadow-lg hover:shadow-[#C8102E]/10 dark:border-slate-800 dark:bg-slate-900"
                    >
                        <div
                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#C8102E]/10 text-xl transition duration-200 group-hover:bg-[#C8102E]/20"
                        >
                            📝
                        </div>

                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Laporkan Aduan
                        </h3>

                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400"
                        >
                            Sampaikan keluhan atau permasalahan layanan
                            dengan informasi yang lengkap.
                        </p>
                    </div>

                    {{-- CARD 2 --}}
                    <div
                        class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-[#C8102E]/40 hover:shadow-lg hover:shadow-[#C8102E]/10 dark:border-slate-800 dark:bg-slate-900"
                    >
                        <div
                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#C8102E]/10 text-xl transition duration-200 group-hover:bg-[#C8102E]/20"
                        >
                            🔄
                        </div>

                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Diproses Divisi Terkait
                        </h3>

                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400"
                        >
                            Aduan diteruskan secara otomatis kepada divisi
                            yang bertanggung jawab.
                        </p>
                    </div>

                    {{-- CARD 3 --}}
                    <div
                        class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-[#C8102E]/40 hover:shadow-lg hover:shadow-[#C8102E]/10 dark:border-slate-800 dark:bg-slate-900"
                    >
                        <div
                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#C8102E]/10 text-xl transition duration-200 group-hover:bg-[#C8102E]/20"
                        >
                            ✅
                        </div>

                        <h3 class="font-semibold text-slate-900 dark:text-white">
                            Pantau Penyelesaian
                        </h3>

                        <p
                            class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400"
                        >
                            Pantau perkembangan laporan hingga proses
                            penyelesaian selesai.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        {{-- =====================================================
             ALUR
        ====================================================== --}}
        <section id="alur">
            <div
                class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8"
            >
                <div class="mx-auto max-w-2xl text-center">

                    <h2
                        class="text-2xl font-bold text-slate-900 sm:text-3xl dark:text-white"
                    >
                        Alur Penanganan Aduan
                    </h2>

                    <p
                        class="mt-4 text-sm text-slate-600 sm:text-base dark:text-slate-400"
                    >
                        Proses penanganan aduan dilakukan secara bertahap
                        hingga laporan dinyatakan selesai.
                    </p>
                </div>

                {{-- STEPS --}}
                <div class="mt-10 grid gap-8 md:grid-cols-4">

                    {{-- STEP 1 --}}
                    <div class="text-center">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#C8102E] font-bold text-white shadow-lg shadow-[#C8102E]/20"
                        >
                            1
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Aduan Dikirim
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Pengguna mengirim laporan melalui sistem.
                        </p>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="text-center">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#C8102E] font-bold text-white shadow-lg shadow-[#C8102E]/20"
                        >
                            2
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Validasi CC Room
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Aduan diperiksa dan divalidasi.
                        </p>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="text-center">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#C8102E] font-bold text-white shadow-lg shadow-[#C8102E]/20"
                        >
                            3
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Ditangani Divisi
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Aduan diteruskan kepada divisi terkait.
                        </p>
                    </div>

                    {{-- STEP 4 --}}
                    <div class="text-center">
                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#C8102E] font-bold text-white shadow-lg shadow-[#C8102E]/20"
                        >
                            4
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Selesai
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Hasil penanganan divalidasi oleh CC Room.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer
        class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900"
    >
        <div
            class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
        >
            <div
                class="flex flex-col items-center justify-between gap-4 text-center sm:flex-row sm:text-left"
            >
                <div>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">
                        Trans Semarang
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Sistem Informasi Aduan
                    </p>
                </div>

                <p class="text-xs text-slate-500">
                    © {{ date('Y') }} Trans Semarang
                </p>
            </div>
        </div>
    </footer>


    {{-- =========================================================
         LOGIN MODAL
    ========================================================== --}}
    <div
        x-show="loginModal"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4 backdrop-blur-sm"
    >
        {{-- MODAL BOX --}}
        <div
            x-show="loginModal"
            x-transition
            @click.outside="loginModal = false"
            class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-900 sm:p-8"
        >

            {{-- HEADER --}}
            <div class="text-center">

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#C8102E]/10 text-2xl"
                >
                    🔐
                </div>

                <h2
                    class="mt-5 text-xl font-bold text-slate-900 dark:text-white"
                >
                    Masuk ke Sistem
                </h2>

                <p
                    class="mt-2 text-sm text-slate-600 dark:text-slate-400"
                >
                    Pilih jenis akun yang ingin digunakan.
                </p>
            </div>


            {{-- OPTIONS --}}
            <div class="mt-7 space-y-3">

                {{-- PENGGUNA --}}
                <a
                    href="{{ route('login') }}"
                    class="group flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 transition duration-200 hover:border-[#C8102E]/50 hover:bg-[#C8102E]/10 hover:shadow-lg hover:shadow-[#C8102E]/10 active:scale-[0.98] dark:border-slate-700 dark:bg-slate-800/50"
                >
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#C8102E]/10 text-xl transition duration-200 group-hover:bg-[#C8102E]/20"
                    >
                        👤
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-slate-900 dark:text-white">
                            Pengguna
                        </div>

                        <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Buat dan pantau aduan Anda.
                        </div>
                    </div>

                    <div
                        class="text-slate-400 transition duration-200 group-hover:translate-x-1 group-hover:text-[#C8102E]"
                    >
                        →
                    </div>
                </a>


                {{-- INTERNAL --}}
                <a
                    href="{{ route('internal.login') }}"
                    class="group flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 transition duration-200 hover:border-[#C8102E]/50 hover:bg-[#C8102E]/10 hover:shadow-lg hover:shadow-[#C8102E]/10 active:scale-[0.98] dark:border-slate-700 dark:bg-slate-800/50"
                >
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#C8102E]/10 text-xl transition duration-200 group-hover:bg-[#C8102E]/20"
                    >
                        🏢
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-slate-900 dark:text-white">
                            Login Internal
                        </div>

                        <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Untuk CC Room dan Manager.
                        </div>
                    </div>

                    <div
                        class="text-slate-400 transition duration-200 group-hover:translate-x-1 group-hover:text-[#C8102E]"
                    >
                        →
                    </div>
                </a>
            </div>


            {{-- CANCEL --}}
            <button
                type="button"
                @click="loginModal = false"
                class="mt-6 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-medium text-slate-600 transition duration-200 hover:border-slate-400 hover:bg-slate-100 hover:text-slate-900 active:scale-[0.98] dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-800 dark:hover:text-white"
            >
                Batal
            </button>
        </div>
    </div>

</body>
</html>
