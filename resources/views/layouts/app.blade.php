<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'Sistem Aduan Trans Semarang') }}
    </title>

    {{-- Fonts --}}
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    >

    {{-- =====================================================
         THEME INITIALIZATION
         Mencegah flash saat halaman pertama kali dibuka.
         Nilai theme:
         - system
         - light
         - dark
    ====================================================== --}}
    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');

            const systemDark = window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches;

            const isDark =
                savedTheme === 'dark' ||
                (
                    savedTheme !== 'light' &&
                    systemDark
                );

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

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
    class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
>

    <div class="min-h-screen">

        {{-- =================================================
             NAVIGATION
        ================================================== --}}
        @include('layouts.navigation')


        {{-- =================================================
             PAGE HEADING
        ================================================== --}}
        @isset($header)
            <header
                class="border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900/95"
            >
                <div
                    class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8"
                >
                    {{ $header }}
                </div>
            </header>
        @endisset


        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}
        <main>
            {{ $slot }}
        </main>

    </div>

</body>
</html>
