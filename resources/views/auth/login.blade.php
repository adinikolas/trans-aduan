<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Pengguna - Sistem Aduan Trans Semarang</title>

    <script>
        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-white">

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 sm:py-12">

        {{-- BACKGROUND GLOW --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div class="absolute left-1/2 top-0 h-96 w-96 -translate-x-1/2 rounded-full bg-[#C8102E]/10 blur-3xl dark:bg-[#C8102E]/10"></div>

            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#A50D25]/10 blur-3xl"></div>

            <div class="absolute bottom-1/3 left-0 h-64 w-64 rounded-full bg-[#C8102E]/5 blur-3xl"></div>

        </div>

        {{-- THEME TOGGLE --}}
        <div class="absolute right-4 top-4 z-20 sm:right-6 sm:top-6">
            <x-theme-toggle />
        </div>

        {{-- LOGIN CONTAINER --}}
        <div class="relative z-10 w-full max-w-md">

            {{-- CARD --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl shadow-slate-900/10 backdrop-blur transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/95 dark:shadow-black/30 sm:p-8">

                {{-- LOGO --}}
                <div class="flex justify-center">
                    <div class="flex h-16 w-16 items-center justify-center">
                        <x-application-logo class="h-16 w-16" />
                    </div>
                </div>

                {{-- TITLE --}}
                <div class="mt-6 text-center">

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Login Pengguna
                    </h1>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Masuk untuk membuat dan memantau aduan Trans Semarang.
                    </p>

                </div>

                {{-- SESSION STATUS --}}
                <x-auth-session-status
                    class="mt-5"
                    :status="session('status')"
                />

                {{-- FORM --}}
                <form method="POST" action="{{ route('login') }}" class="mt-7">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email Anda"
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition duration-200 focus:border-[#C8102E] focus:ring-2 focus:ring-[#C8102E]/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder-slate-500"
                        >

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mt-5">
                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition duration-200 focus:border-[#C8102E] focus:ring-2 focus:ring-[#C8102E]/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder-slate-500"
                        >

                        {{-- LOGIN CREDENTIAL ERROR --}}
                        @if ($errors->has('password'))
                            <div class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    {{-- REMEMBER + FORGOT --}}
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">

                        <label
                            for="remember_me"
                            class="inline-flex cursor-pointer items-center"
                        >
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-slate-300 bg-white text-[#C8102E] shadow-sm focus:ring-[#C8102E] dark:border-slate-700 dark:bg-slate-950"
                            >

                            <span class="ms-2 text-sm text-slate-500 dark:text-slate-400">
                                Ingat saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-slate-500 transition duration-200 hover:text-[#C8102E] dark:text-slate-400 dark:hover:text-[#E21D3F]"
                            >
                                Lupa password?
                            </a>
                        @endif

                    </div>

                    {{-- SUBMIT --}}
                    <button
                        type="submit"
                        class="mt-7 w-full rounded-xl bg-[#C8102E] px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition duration-200 hover:bg-[#A50D25] hover:shadow-[#C8102E]/40 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-[#C8102E] focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-900"
                    >
                        Masuk ke Sistem
                    </button>

                </form>

                {{-- REGISTER --}}
                <div class="mt-6 border-t border-slate-200 pt-6 text-center dark:border-slate-800">

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Belum memiliki akun?
                    </p>

                    <a
                        href="{{ route('register') }}"
                        class="mt-2 inline-block text-sm font-semibold text-[#C8102E] transition duration-200 hover:text-[#A50D25] dark:text-[#E21D3F] dark:hover:text-red-300"
                    >
                        Daftar Pengguna Baru →
                    </a>

                </div>

                {{-- INTERNAL LOGIN --}}
                <div class="mt-6 border-t border-slate-200 pt-6 text-center dark:border-slate-800">

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Anda bagian dari internal Trans Semarang?
                    </p>

                    <a
                        href="{{ route('internal.login') }}"
                        class="mt-2 inline-block text-sm font-semibold text-[#C8102E] transition duration-200 hover:text-[#A50D25] dark:text-[#E21D3F] dark:hover:text-red-300"
                    >
                        Login Internal →
                    </a>

                </div>

                {{-- BACK HOME --}}
                <div class="mt-5 text-center">

                    <a
                        href="{{ url('/') }}"
                        class="text-sm text-slate-500 transition duration-200 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white"
                    >
                        ← Kembali ke halaman utama
                    </a>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="mt-6 text-center">

                <p class="text-xs text-slate-500 dark:text-slate-600">
                    © {{ date('Y') }} Trans Semarang
                </p>

            </div>

        </div>

    </div>

</body>
</html>
