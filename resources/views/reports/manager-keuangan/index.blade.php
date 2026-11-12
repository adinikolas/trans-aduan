<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                Laporan Aduan - Manager Keuangan
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Unduh laporan aduan Divisi Keuangan berdasarkan periode dan status.
            </p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- INFORMASI --}}
            <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-900/50 dark:bg-blue-900/20">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">📊</div>

                    <div>
                        <h3 class="font-semibold text-blue-900 dark:text-blue-300">
                            Export Data Aduan
                        </h3>

                        <p class="mt-1 text-sm text-blue-800 dark:text-blue-400">
                            Laporan hanya mencakup aduan yang telah didisposisikan
                            ke Divisi Keuangan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-700 sm:px-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Filter Laporan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Tentukan periode dan status aduan yang ingin diunduh.
                    </p>
                </div>

                <form method="GET" action="{{ route('reports.export') }}" class="p-5 sm:p-6">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- BULAN --}}
                        <div>
                            <label for="month"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Bulan
                            </label>

                            <select name="month" id="month"
                                class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-[#C8102E] focus:ring-[#C8102E]/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                                <option value="">Semua Bulan</option>

                                @foreach ([
                                    1 => 'Januari', 2 => 'Februari',
                                    3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni',
                                    7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober',
                                    11 => 'November', 12 => 'Desember',
                                ] as $number => $name)

                                    <option value="{{ $number }}"
                                        {{ request('month') == $number ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>

                                @endforeach
                            </select>
                        </div>

                        {{-- TAHUN --}}
                        <div>
                            <label for="year"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tahun
                            </label>

                            <select name="year" id="year"
                                class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-[#C8102E] focus:ring-[#C8102E]/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                                <option value="">Semua Tahun</option>

                                @for ($year = now()->year; $year >= now()->year - 5; $year--)

                                    <option value="{{ $year }}"
                                        {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>

                                @endfor
                            </select>
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label for="status"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status Aduan
                            </label>

                            <select name="status" id="status"
                                class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-[#C8102E] focus:ring-[#C8102E]/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                                <option value="">Semua Status</option>

                                <option value="menunggu"
                                    {{ request('status') === 'menunggu' ? 'selected' : '' }}>
                                    Menunggu Verifikasi
                                </option>

                                <option value="diproses"
                                    {{ request('status') === 'diproses' ? 'selected' : '' }}>
                                    Sedang Ditangani
                                </option>

                                <option value="menunggu_validasi_cc"
                                    {{ request('status') === 'menunggu_validasi_cc' ? 'selected' : '' }}>
                                    Menunggu Validasi
                                </option>

                                <option value="selesai"
                                    {{ request('status') === 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>

                                <option value="ditolak"
                                    {{ request('status') === 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>

                            </select>
                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-7 flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 dark:border-gray-700 sm:flex-row sm:justify-end">

                        <a href="{{ route('reports.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-700">
                            Reset Filter
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C8102E] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition hover:bg-[#A50D25] active:scale-[0.98]">
                            Export Excel
                        </button>

                    </div>
                </form>
            </div>

            {{-- INFORMASI KOLOM --}}
            <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <h3 class="font-semibold text-gray-900 dark:text-white">
                    Informasi Data Excel
                </h3>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    File Excel akan berisi informasi berikut:
                </p>

                <div class="mt-4 flex flex-wrap gap-2">

                    @foreach ([
                        'No', 'Tanggal', 'Jam', 'Pelapor',
                        'Pengemudi', 'No Armada', 'TKP',
                        'Jenis Aduan', 'Isi Aduan',
                        'Keterangan', 'Status',
                    ] as $column)

                        <span class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $column }}
                        </span>

                    @endforeach

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
