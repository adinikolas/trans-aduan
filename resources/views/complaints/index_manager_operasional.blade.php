<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard Manager Operasional
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Penanganan aduan terkait armada, fasilitas, pengemudi, dan operasional layanan.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- INFO DIVISI -->
            <div class="mb-6 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-5">

                <div class="flex items-start gap-4">

                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-full text-xl">
                        ⚙️
                    </div>

                    <div>

                        <h3 class="font-bold text-indigo-900 dark:text-indigo-300">
                            Ruang Kerja Operasional
                        </h3>

                        <p class="text-sm text-indigo-700 dark:text-indigo-400 mt-1">
                            Halaman ini hanya menampilkan aduan yang telah
                            didisposisikan ke Divisi Operasional.
                        </p>

                    </div>

                </div>

            </div>


            <!-- SEARCH & FILTER -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

                <form
                    method="GET"
                    action="{{ route('complaints.index') }}"
                    class="flex flex-col sm:flex-row gap-4"
                >

                    <div class="flex-1">

                        <label for="search" class="sr-only">
                            Cari Tiket
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari No. Tiket atau Judul Laporan..."
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >

                    </div>


                    <div class="sm:w-52">

                        <select
                            name="status"
                            id="status"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >

                            <option value="">
                                Semua Status
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
                                Menunggu Validasi CC
                            </option>

                        </select>

                    </div>


                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition"
                        >
                            Terapkan
                        </button>

                        @if(request('search') || request('status'))

                            <a
                                href="{{ route('complaints.index') }}"
                                class="w-full sm:w-auto px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-md shadow-sm transition text-center"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </div>


            <!-- TABLE -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-0 sm:p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    No. Tiket
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Pelapor
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kategori
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Judul Laporan
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($complaints as $complaint)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{ $complaint->ticket_number }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $complaint->user->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $complaint->category->name }}
                                    </td>

                                    <td
                                        class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 max-w-xs truncate"
                                        title="{{ $complaint->title }}"
                                    >
                                        {{ $complaint->title }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        @if($complaint->status === 'diproses')

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                                Diproses
                                            </span>

                                        @else

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400">
                                                Menunggu Validasi CC
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">

                                        <a
                                            href="{{ route('complaints.show', $complaint->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold transition"
                                        >
                                            Lihat Detail →
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-12 text-center"
                                    >

                                        <div class="text-4xl mb-3">
                                            📭
                                        </div>

                                        <p class="font-semibold text-gray-700 dark:text-gray-300">
                                            Tidak ada aduan operasional
                                        </p>

                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Belum ada aduan yang perlu ditangani.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if($complaints->hasPages())

                    <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $complaints->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>
