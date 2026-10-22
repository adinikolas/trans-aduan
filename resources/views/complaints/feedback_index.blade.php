
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">
                Ulasan Pengguna
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Rekap penilaian dan masukan pengguna terhadap penyelesaian aduan.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Total Ulasan
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                        {{ $complaints->total() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Halaman Saat Ini
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                        {{ $complaints->currentPage() }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Data Ditampilkan
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                        {{ $complaints->count() }}
                    </p>
                </div>
            </div>

            {{-- PENCARIAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <form
                    action="{{ route('feedback.index') }}"
                    method="GET"
                    class="flex flex-col gap-3 sm:flex-row"
                >
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nomor tiket, judul aduan, atau nama pengguna..."
                        class="w-full rounded-xl border-slate-300 bg-white text-sm text-slate-900 placeholder-slate-400 focus:border-[#C8102E] focus:ring-[#C8102E] dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="rounded-xl bg-[#C8102E] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-800"
                        >
                            Cari
                        </button>

                        <a
                            href="{{ route('feedback.index') }}"
                            class="rounded-xl border border-slate-300 px-5 py-2.5 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- DAFTAR ULASAN --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                    <h3 class="font-semibold text-slate-900 dark:text-white">
                        Daftar Ulasan
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Ulasan yang telah diberikan untuk aduan yang selesai.
                    </p>
                </div>

                @if($complaints->isEmpty())
                    <div class="px-6 py-14 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">
                            <svg
                                class="h-7 w-7 text-slate-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                        </div>

                        <h4 class="mt-4 font-semibold text-slate-900 dark:text-white">
                            Belum ada ulasan
                        </h4>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Ulasan pengguna akan muncul di halaman ini setelah tersedia.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                            <thead class="bg-slate-50 dark:bg-slate-800/70">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Aduan
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Pengguna
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Divisi
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Rating
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Komentar
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                @foreach($complaints as $complaint)
                                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">

                                        {{-- ADUAN --}}
                                        <td class="px-5 py-4 align-top">
                                            <a
                                                href="{{ route('complaints.show', $complaint->id) }}"
                                                class="font-semibold text-[#C8102E] hover:underline"
                                            >
                                                {{ $complaint->ticket_number }}
                                            </a>

                                            <p class="mt-1 min-w-40 text-sm text-slate-700 dark:text-slate-300">
                                                {{ $complaint->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                {{ $complaint->category->name ?? 'Tanpa kategori' }}
                                            </p>
                                        </td>

                                        {{-- PENGGUNA --}}
                                        <td class="px-5 py-4 align-top">
                                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                                {{ $complaint->user->name ?? 'Pengguna tidak tersedia' }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                {{ $complaint->user->email ?? '-' }}
                                            </p>
                                        </td>

                                        {{-- DIVISI --}}
                                        <td class="px-5 py-4 align-top text-sm text-slate-700 dark:text-slate-300">
                                            {{ $complaint->division->name ?? 'Belum ditentukan' }}
                                        </td>

                                        {{-- RATING --}}
                                        <td class="px-5 py-4 align-top">
                                            <div class="flex items-center gap-1 whitespace-nowrap" aria-label="Rating {{ $complaint->feedback->rating }} dari 5">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <span class="{{ $star <= $complaint->feedback->rating ? 'text-amber-400' : 'text-slate-300 dark:text-slate-600' }}">
                                                        ★
                                                    </span>
                                                @endfor
                                            </div>

                                            <p class="mt-1 text-xs font-medium text-slate-600 dark:text-slate-400">
                                                {{ $complaint->feedback->rating }}/5
                                            </p>
                                        </td>

                                        {{-- KOMENTAR --}}
                                        <td class="px-5 py-4 align-top">
                                            <p class="min-w-48 max-w-xs whitespace-pre-line break-words text-sm text-slate-700 dark:text-slate-300">
                                                {{ filled($complaint->feedback->comment)
                                                    ? $complaint->feedback->comment
                                                    : 'Tidak ada komentar.' }}
                                            </p>
                                        </td>

                                        {{-- TANGGAL --}}
                                        <td class="px-5 py-4 align-top text-sm text-slate-500 dark:text-slate-400">
                                            {{ $complaint->feedback->created_at
                                                ? $complaint->feedback->created_at->format('d/m/Y H:i')
                                                : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
