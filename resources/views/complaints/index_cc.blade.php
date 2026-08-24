<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard CC Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- 1. WIDGET STATISTIK DASHBOARD -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Kotak Total Aduan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500 transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Semua Laporan</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">{{ $totalAduan ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <span class="text-xl">📁</span>
                        </div>
                    </div>
                </div>

                <!-- Kotak Menunggu Verifikasi -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">{{ $menunggu ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                            <span class="text-xl">⏳</span>
                        </div>
                    </div>
                </div>

                <!-- Kotak Sedang Diproses -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500 transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Ditangani</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">{{ $diproses ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-full">
                            <span class="text-xl">⚙️</span>
                        </div>
                    </div>
                </div>

                <!-- Kotak Selesai -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500 transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aduan Selesai</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mt-1">{{ $selesai ?? 0 }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <span class="text-xl">✅</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AKHIR WIDGET STATISTIK -->

            <!-- 2. PANEL PENCARIAN & FILTER -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ route('complaints.index') }}" class="flex flex-col sm:flex-row gap-4">

                    <div class="flex-1">
                        <label for="search" class="sr-only">Cari Tiket</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari No. Tiket atau Judul Laporan..."
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150">
                    </div>

                    <div class="sm:w-48">
                        <label for="status" class="sr-only">Filter Status</label>
                        <select name="status" id="status"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="menunggu_validasi_cc" {{ request('status') == 'menunggu_validasi_cc' ? 'selected' : '' }}>Menunggu Validasi CC</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white text-sm font-semibold rounded-md shadow-sm transition">
                            Terapkan
                        </button>

                        @if(request('search') || request('status'))
                            <a href="{{ route('complaints.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-md shadow-sm transition text-center flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <!-- AKHIR PANEL PENCARIAN -->

            <!-- 3. TABEL DATA -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0 sm:p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Tiket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul Laporan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($complaints as $complaint)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $complaint->ticket_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $complaint->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $complaint->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 max-w-[150px] sm:max-w-xs truncate" title="{{ $complaint->title }}">
                                        {{ $complaint->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($complaint->status === 'menunggu')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-500">Menunggu Verifikasi</span>
                                        @elseif ($complaint->status === 'diproses')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-500">Diproses</span>
                                        @elseif ($complaint->status === 'menunggu_validasi_cc')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-500">Validasi CC</span>
                                        @elseif ($complaint->status === 'selesai')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-500">Selesai</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-500">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('complaints.show', $complaint->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold transition">
                                            Lihat Detail &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($complaints->isEmpty())
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            Tidak ada data aduan yang ditemukan.
                        </div>
                    @endif

                </div>

                <!-- PAGINASI UNTUK CC ROOM -->
                @if($complaints->hasPages())
                    <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $complaints->links() }}
                    </div>
                @endif
                <!-- AKHIR PAGINASI -->

            </div>
            <!-- AKHIR TABEL DATA -->

        </div>
    </div>
</x-app-layout>
