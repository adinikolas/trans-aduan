<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">
                    Riwayat Laporan Saya
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Pantau perkembangan aduan yang telah Anda kirim.
                </p>
            </div>

            <a
                href="{{ route('complaints.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-[#C8102E] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition hover:bg-[#A50D25] hover:shadow-[#C8102E]/30 active:scale-[0.98]"
            >
                + Buat Laporan Baru
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-100 py-8 dark:bg-slate-950 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- STATISTICS --}}
            <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- TOTAL --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Total Laporan
                    </p>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $totalAduan }}
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#C8102E]/10 text-lg">
                            📋
                        </div>
                    </div>
                </div>

                {{-- DIPROSES --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Sedang Diproses
                    </p>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $menunggu + $diproses }}
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-lg">
                            🔄
                        </div>
                    </div>
                </div>

                {{-- SELESAI --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Selesai
                    </p>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $selesai }}
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500/10 text-lg">
                            ✅
                        </div>
                    </div>
                </div>

                {{-- DITOLAK --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Ditolak
                    </p>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">
                            {{ $ditolak }}
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500/10 text-lg">
                            ❌
                        </div>
                    </div>
                </div>

            </div>

            {{-- SEARCH --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form
                    method="GET"
                    action="{{ route('complaints.index') }}"
                    class="grid gap-4 md:grid-cols-[1fr_220px_auto]"
                >
                    <div>
                        <label
                            for="search"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Cari Laporan
                        </label>

                        <input
                            id="search"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="No. tiket atau judul laporan..."
                            class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-[#C8102E] focus:ring-2 focus:ring-[#C8102E]/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>

                    <div>
                        <label
                            for="status"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-[#C8102E] focus:ring-2 focus:ring-[#C8102E]/20 dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        >
                            <option value="">Semua Status</option>

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
                                Diproses
                            </option>

                            <option
                                value="menunggu_validasi_cc"
                                {{ request('status') === 'menunggu_validasi_cc' ? 'selected' : '' }}
                            >
                                Menunggu Validasi Akhir
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

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 rounded-xl bg-[#C8102E] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition hover:bg-[#A50D25] active:scale-[0.98] md:flex-none"
                        >
                            Cari
                        </button>

                        @if (request('search') || request('status'))
                            <a
                                href="{{ route('complaints.index') }}"
                                class="flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:bg-slate-800"
                            >
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800 sm:px-6">
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Daftar Laporan
                    </h3>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Menampilkan laporan yang Anda kirim melalui sistem.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/50">
                            <tr>
                                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    No. Tiket
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Kategori
                                </th>

                                <th class="min-w-[220px] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Judul Laporan
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Waktu Kejadian
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Status
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse ($complaints as $complaint)
                                <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">

                                    {{-- TICKET --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="text-sm font-semibold text-[#C8102E]">
                                            {{ $complaint->ticket_number }}
                                        </span>
                                    </td>

                                    {{-- CATEGORY --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $complaint->category->name }}
                                    </td>

                                    {{-- TITLE --}}
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs truncate text-sm font-medium text-slate-900 dark:text-white">
                                            {{ $complaint->title }}
                                        </div>
                                    </td>

                                    {{-- INCIDENT --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                        {{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y, H:i') }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($complaint->status === 'menunggu')
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif ($complaint->status === 'diproses')
                                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                Diproses
                                            </span>
                                        @elseif ($complaint->status === 'menunggu_validasi_cc')
                                            <span class="inline-flex rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                                Validasi Akhir
                                            </span>
                                        @elseif ($complaint->status === 'selesai')
                                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                Selesai
                                            </span>
                                        @elseif ($complaint->status === 'ditolak')
                                            <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="{{ route('complaints.show', $complaint->id) }}"
                                                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-[#C8102E]/40 hover:bg-[#C8102E]/5 hover:text-[#C8102E] dark:border-slate-700 dark:text-slate-300 dark:hover:border-[#C8102E]/40 dark:hover:text-[#C8102E]"
                                            >
                                                Detail
                                            </a>

                                            @if ($complaint->status === 'selesai' && !$complaint->feedback)
                                                <a
                                                    href="{{ route('complaints.feedback', $complaint->id) }}"
                                                    class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-green-700"
                                                >
                                                    Ulasan ⭐
                                                </a>
                                            @elseif ($complaint->status === 'selesai' && $complaint->feedback)
                                                <span class="rounded-lg bg-yellow-100 px-3 py-1.5 text-xs font-semibold text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    ⭐ {{ $complaint->feedback->rating }}/5
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl dark:bg-slate-800">
                                            📋
                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                                            Belum ada laporan
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                            Anda belum memiliki riwayat aduan.
                                        </p>

                                        <a
                                            href="{{ route('complaints.create') }}"
                                            class="mt-5 inline-flex items-center rounded-xl bg-[#C8102E] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#A50D25]"
                                        >
                                            Buat Laporan Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($complaints->hasPages())
                    <div class="border-t border-slate-200 bg-slate-50 px-5 py-4 dark:border-slate-800 dark:bg-slate-950/50 sm:px-6">
                        {{ $complaints->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
