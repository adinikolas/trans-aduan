<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Aduan Operasional
            </h2>

            <p class="mt-1 text-sm sm:text-base text-slate-500 dark:text-slate-400">
                Kelola dan tindak lanjuti aduan yang ditangani Divisi Operasional.
            </p>
        </div>
    </x-slot>


    <div class="py-8 sm:py-10 lg:py-12">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">


            {{-- ==========================================================
                 INFO DIVISI
            =========================================================== --}}

            <div class="rounded-2xl border border-indigo-500/30 bg-indigo-950/20 p-5 sm:p-6">

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-500/15 text-xl"
                    >
                        ⚙️
                    </div>

                    <div class="min-w-0">

                        <h3 class="font-semibold text-indigo-300">
                            Ruang Kerja Operasional
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-indigo-200/70">
                            Menampilkan aduan yang telah didisposisikan
                            ke Divisi Operasional untuk ditindaklanjuti.
                        </p>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                 SEARCH & FILTER
            =========================================================== --}}

            <div class="rounded-2xl border border-slate-700/80 bg-slate-800/90 p-4 sm:p-5 shadow-sm">

                <form
                    method="GET"
                    action="{{ route('manager.operasional.aduan') }}"
                    class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
                >

                    {{-- SEARCH --}}

                    <div>

                        <label
                            for="search"
                            class="mb-2 block text-sm font-medium text-slate-300"
                        >
                            Cari Aduan
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari tiket, judul laporan, atau nama pelapor..."
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-slate-200 placeholder-slate-500 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                        >

                    </div>


                    {{-- STATUS --}}

                    <div>

                        <label
                            for="status"
                            class="mb-2 block text-sm font-medium text-slate-300"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-slate-200 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                        >

                            <option value="">
                                Semua Status
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

                        </select>

                    </div>


                    {{-- BUTTONS --}}

                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-[#C8102E] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition hover:bg-[#A80D26] focus:outline-none focus:ring-2 focus:ring-[#C8102E]/40"
                        >
                            Terapkan
                        </button>


                        @if(request('search') || request('status'))

                            <a
                                href="{{ route('manager.operasional.aduan') }}"
                                class="rounded-xl border border-slate-600 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </div>


            {{-- ==========================================================
                 TABLE
            =========================================================== --}}

            <div class="overflow-hidden rounded-2xl border border-slate-700/80 bg-slate-800/90 shadow-sm">


                {{-- TABLE HEADER --}}

                <div class="border-b border-slate-700/80 px-5 py-5 sm:px-6">

                    <h3 class="text-lg sm:text-xl font-bold text-white">
                        Daftar Aduan Operasional
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        Aduan yang sedang ditangani oleh Divisi Operasional.
                    </p>

                </div>


                {{-- TABLE WRAPPER --}}

                <div class="overflow-x-auto">

                    <table class="min-w-[900px] w-full">

                        <thead class="bg-slate-900/70">

                            <tr>

                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    No. Tiket
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Pelapor
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Kategori
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Judul Laporan
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-700/70">

                            @forelse($complaints as $complaint)

                                <tr class="transition hover:bg-slate-700/25">


                                    {{-- TICKET --}}

                                    <td class="whitespace-nowrap px-5 py-5">

                                        <span class="font-semibold text-indigo-400">
                                            {{ $complaint->ticket_number }}
                                        </span>

                                    </td>


                                    {{-- USER --}}

                                    <td class="whitespace-nowrap px-5 py-5 text-sm text-slate-300">
                                        {{ $complaint->user->name }}
                                    </td>


                                    {{-- CATEGORY --}}

                                    <td class="whitespace-nowrap px-5 py-5 text-sm text-slate-400">
                                        {{ $complaint->category->name }}
                                    </td>


                                    {{-- TITLE --}}

                                    <td
                                        class="max-w-xs px-5 py-5 text-sm text-slate-200"
                                        title="{{ $complaint->title }}"
                                    >

                                        <div class="truncate">
                                            {{ $complaint->title }}
                                        </div>

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="whitespace-nowrap px-5 py-5">

                                        @if($complaint->status === 'diproses')

                                            <span class="inline-flex items-center rounded-full bg-blue-500/15 px-3 py-1 text-xs font-semibold text-blue-400">
                                                Sedang Ditangani
                                            </span>

                                        @elseif($complaint->status === 'menunggu_validasi_cc')

                                            <span class="inline-flex items-center rounded-full bg-purple-500/15 px-3 py-1 text-xs font-semibold text-purple-400">
                                                Menunggu Validasi
                                            </span>

                                        @elseif($complaint->status === 'selesai')

                                            <span class="inline-flex items-center rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold text-emerald-400">
                                                Selesai
                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-full bg-slate-500/15 px-3 py-1 text-xs font-semibold text-slate-400">
                                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACTION --}}

                                    <td class="whitespace-nowrap px-5 py-5 text-center">

                                        <a
                                            href="{{ route('complaints.show', $complaint->id) }}"
                                            class="inline-flex items-center gap-2 rounded-xl border border-slate-600 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-indigo-400/50 hover:bg-indigo-500/10 hover:text-indigo-300"
                                        >
                                            Lihat Detail
                                            <span>→</span>
                                        </a>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-16 text-center"
                                    >

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-700/50 text-2xl">
                                            📭
                                        </div>

                                        <p class="mt-4 font-semibold text-slate-200">
                                            Tidak ada aduan operasional
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Belum ada aduan yang perlu ditangani.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}

                @if($complaints->hasPages())

                    <div class="border-t border-slate-700/80 bg-slate-900/30 px-5 py-4 sm:px-6">
                        {{ $complaints->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
