<x-app-layout>

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <x-slot name="header">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                    Dashboard CC Room
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola, verifikasi, dan teruskan aduan ke divisi terkait.
                </p>
            </div>

        </div>

    </x-slot>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}
    <div class="py-8 sm:py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                 SUCCESS MESSAGE
            ====================================================== --}}
            @if (session('success'))

                <div
                    class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-400"
                    role="alert"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- =====================================================
                 STATISTICS
            ====================================================== --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">


                {{-- TOTAL --}}
                <div
                    class="rounded-2xl border border-gray-200 border-l-4 border-l-blue-500 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:border-l-blue-500 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Total Aduan
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $totalAduan ?? 0 }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-xl dark:bg-blue-900/30">
                            📁
                        </div>

                    </div>
                </div>


                {{-- MENUNGGU --}}
                <div
                    class="rounded-2xl border border-gray-200 border-l-4 border-l-yellow-500 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:border-l-yellow-500 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Menunggu Verifikasi
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $menunggu ?? 0 }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-yellow-100 text-xl dark:bg-yellow-900/30">
                            ⏳
                        </div>

                    </div>
                </div>


                {{-- DIPROSES --}}
                <div
                    class="rounded-2xl border border-gray-200 border-l-4 border-l-blue-500 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:border-l-blue-500 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Sedang Ditangani
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $diproses ?? 0 }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-xl dark:bg-blue-900/30">
                            ⚙️
                        </div>

                    </div>
                </div>


                {{-- MENUNGGU VALIDASI --}}
                <div
                    class="rounded-2xl border border-gray-200 border-l-4 border-l-purple-500 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:border-l-purple-500 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Menunggu Validasi
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $menungguValidasi ?? 0 }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 text-xl dark:bg-purple-900/30">
                            🔍
                        </div>

                    </div>
                </div>


                {{-- SELESAI --}}
                <div
                    class="rounded-2xl border border-gray-200 border-l-4 border-l-green-500 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:border-l-green-500 dark:bg-gray-800"
                >
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Selesai
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $selesai ?? 0 }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-xl dark:bg-green-900/30">
                            ✅
                        </div>

                    </div>
                </div>

            </div>


            {{-- =====================================================
                 SEARCH & FILTER
            ====================================================== --}}
            <div
                class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-5"
            >

                <form
                    method="GET"
                    action="{{ route('complaints.index') }}"
                    class="grid grid-cols-1 gap-4 lg:grid-cols-12"
                >

                    {{-- SEARCH --}}
                    <div class="lg:col-span-7">

                        <label
                            for="search"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Cari Aduan
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari tiket, judul laporan, atau nama pelapor..."
                            class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-[#C8102E] focus:ring-[#C8102E]/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500"
                        >

                    </div>


                    {{-- STATUS --}}
                    <div class="lg:col-span-3">

                        <label
                            for="status"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-[#C8102E] focus:ring-[#C8102E]/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        >

                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="menunggu"
                                {{ request('status') === 'menunggu' ? 'selected' : '' }}
                            >
                                Menunggu Verifikasi
                            </option>

                            <option
                                value="diproses"
                                {{ request('status') === 'diproses' ? 'selected' : '' }}
                            >
                                Sedang Ditangani
                            </option>

                            <option
                                value="menunggu_validasi_cc"
                                {{ request('status') === 'menunggu_validasi_cc' ? 'selected' : '' }}
                            >
                                Menunggu Validasi
                            </option>

                            <option
                                value="selesai"
                                {{ request('status') === 'selesai' ? 'selected' : '' }}
                            >
                                Selesai
                            </option>

                            <option
                                value="ditolak"
                                {{ request('status') === 'ditolak' ? 'selected' : '' }}
                            >
                                Ditolak
                            </option>

                        </select>

                    </div>


                    {{-- BUTTON --}}
                    <div class="flex items-end gap-2 lg:col-span-2">

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-[#C8102E] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition duration-200 hover:bg-[#A50D25] hover:shadow-[#C8102E]/30 active:scale-[0.98]"
                        >
                            Terapkan
                        </button>

                        @if(request('search') || request('status'))

                            <a
                                href="{{ route('complaints.index') }}"
                                class="rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-700"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 TABLE
            ====================================================== --}}
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
            >

                {{-- TABLE HEADER --}}
                <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-700 sm:px-6">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Daftar Aduan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Laporan yang masuk dan perlu dipantau oleh CC Room.
                    </p>

                </div>


                {{-- RESPONSIVE TABLE --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-900/50">

                            <tr>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    No. Tiket
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Pelapor
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Kategori
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Judul Laporan
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th class="whitespace-nowrap px-5 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">

                            @forelse ($complaints as $complaint)

                                <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                    {{-- TICKET --}}
                                    <td class="whitespace-nowrap px-5 py-4">

                                        <span class="text-sm font-semibold text-[#C8102E]">
                                            {{ $complaint->ticket_number }}
                                        </span>

                                    </td>


                                    {{-- USER --}}
                                    <td class="whitespace-nowrap px-5 py-4">

                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $complaint->user->name }}
                                        </span>

                                    </td>


                                    {{-- CATEGORY --}}
                                    <td class="whitespace-nowrap px-5 py-4">

                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $complaint->category->name }}
                                        </span>

                                    </td>


                                    {{-- TITLE --}}
                                    <td class="max-w-xs px-5 py-4">

                                        <p
                                            class="truncate text-sm font-medium text-gray-900 dark:text-white"
                                            title="{{ $complaint->title }}"
                                        >
                                            {{ $complaint->title }}
                                        </p>

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="whitespace-nowrap px-5 py-4">

                                        @switch($complaint->status)

                                            @case('menunggu')

                                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    Menunggu Verifikasi
                                                </span>

                                                @break

                                            @case('diproses')

                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    Sedang Ditangani
                                                </span>

                                                @break

                                            @case('menunggu_validasi_cc')

                                                <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                                    Menunggu Validasi
                                                </span>

                                                @break

                                            @case('selesai')

                                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Selesai
                                                </span>

                                                @break

                                            @case('ditolak')

                                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    Ditolak
                                                </span>

                                                @break

                                            @default

                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                    {{ ucfirst($complaint->status) }}
                                                </span>

                                        @endswitch

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-center">

                                        <a
                                            href="{{ route('complaints.show', $complaint->id) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:border-[#C8102E]/50 hover:bg-[#C8102E]/10 hover:text-[#C8102E] dark:border-gray-600 dark:text-gray-300 dark:hover:border-[#E21D3F]/50 dark:hover:bg-[#C8102E]/10 dark:hover:text-[#E21D3F]"
                                        >
                                            Lihat Detail
                                            <span class="ml-1">
                                                →
                                            </span>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-12 text-center"
                                    >

                                        <div class="text-4xl">
                                            📭
                                        </div>

                                        <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Tidak ada aduan
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                                            Belum ada laporan yang sesuai dengan filter.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}
                @if($complaints->hasPages())

                    <div class="border-t border-gray-200 bg-gray-50 px-5 py-4 dark:border-gray-700 dark:bg-gray-900/30 sm:px-6">

                        {{ $complaints->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
