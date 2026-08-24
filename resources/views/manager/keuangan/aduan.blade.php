<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Aduan Keuangan') }}
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ __('Daftar laporan yang sedang ditangani oleh Manager Keuangan.') }}
            </p>
        </div>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- =========================================================
                 HEADER HALAMAN
            ========================================================== -->

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Daftar Aduan
                    </h1>

                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                        Aduan yang masuk ke bidang keuangan.
                    </p>
                </div>

                <a
                    href="{{ route('manager.keuangan') }}"
                    class="inline-flex items-center justify-center px-4 py-2
                           bg-gray-700 hover:bg-gray-600
                           dark:bg-gray-700 dark:hover:bg-gray-600
                           text-white text-sm font-semibold
                           rounded-md shadow-sm transition"
                >
                    ← Dashboard
                </a>

            </div>


            <!-- =========================================================
                 PANEL PENCARIAN & FILTER
            ========================================================== -->

            <div class="bg-white dark:bg-gray-800
                        border border-gray-200 dark:border-gray-700
                        rounded-lg shadow-sm p-6">

                <form
                    method="GET"
                    action="{{ route('manager.keuangan.aduan') }}"
                    class="space-y-4"
                >

                    <!-- Search -->
                    <div>

                        <label
                            for="search"
                            class="block text-sm font-medium
                                   text-gray-700 dark:text-gray-300 mb-2"
                        >
                            Cari Aduan
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="No. tiket atau judul laporan..."
                            class="block w-full rounded-md
                                   border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-300
                                   shadow-sm
                                   focus:border-indigo-500
                                   focus:ring-indigo-500
                                   sm:text-sm"
                        >

                    </div>


                    <!-- Status -->
                    <div>

                        <label
                            for="status"
                            class="block text-sm font-medium
                                   text-gray-700 dark:text-gray-300 mb-2"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="block w-full rounded-md
                                   border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-gray-300
                                   shadow-sm
                                   focus:border-indigo-500
                                   focus:ring-indigo-500
                                   sm:text-sm"
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


                    <!-- Button -->
                    <div class="flex flex-col sm:flex-row gap-2">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center
                                   px-4 py-2
                                   bg-indigo-600 hover:bg-indigo-700
                                   dark:bg-indigo-500 dark:hover:bg-indigo-600
                                   text-white text-sm font-semibold
                                   rounded-md shadow-sm transition"
                        >
                            Terapkan
                        </button>


                        @if(request('search') || request('status'))

                            <a
                                href="{{ route('manager.keuangan.aduan') }}"
                                class="inline-flex items-center justify-center
                                       px-4 py-2
                                       bg-gray-200 hover:bg-gray-300
                                       dark:bg-gray-700 dark:hover:bg-gray-600
                                       text-gray-800 dark:text-gray-200
                                       text-sm font-semibold
                                       rounded-md shadow-sm transition"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </div>


            <!-- =========================================================
                 TABEL DATA
            ========================================================== -->

            <div class="bg-white dark:bg-gray-800
                        overflow-hidden
                        shadow-sm sm:rounded-lg
                        border border-gray-200 dark:border-gray-700">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <!-- HEADER -->
                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    No. Tiket
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    Pelapor
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    Jenis Aduan
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    Judul
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <!-- BODY -->
                        <tbody class="bg-white dark:bg-gray-800
                                      divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($complaints as $complaint)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                                    <!-- No Tiket -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="text-sm font-semibold
                                                    text-gray-900 dark:text-gray-100">
                                            {{ $complaint->ticket_number }}
                                        </div>

                                    </td>


                                    <!-- Pelapor -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="text-sm font-medium
                                                    text-gray-900 dark:text-gray-100">
                                            {{ $complaint->user->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $complaint->user->email }}
                                        </div>

                                    </td>


                                    <!-- Jenis Aduan -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span class="text-sm
                                                     text-gray-700 dark:text-gray-300">
                                            {{ $complaint->category->name }}
                                        </span>

                                    </td>


                                    <!-- Judul -->
                                    <td class="px-6 py-4">

                                        <div
                                            class="text-sm font-medium
                                                   text-gray-900 dark:text-gray-100
                                                   max-w-xs truncate"
                                            title="{{ $complaint->title }}"
                                        >
                                            {{ $complaint->title }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y H:i') }}
                                        </div>

                                    </td>


                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        @if($complaint->status === 'diproses')

                                            <span
                                                class="inline-flex items-center
                                                       px-3 py-1 rounded-full
                                                       bg-blue-100 dark:bg-blue-900/30
                                                       text-blue-700 dark:text-blue-400
                                                       text-xs font-semibold"
                                            >
                                                Diproses
                                            </span>

                                        @elseif($complaint->status === 'menunggu_validasi_cc')

                                            <span
                                                class="inline-flex items-center
                                                       px-3 py-1 rounded-full
                                                       bg-purple-100 dark:bg-purple-900/30
                                                       text-purple-700 dark:text-purple-400
                                                       text-xs font-semibold"
                                            >
                                                Menunggu Validasi CC
                                            </span>

                                        @elseif($complaint->status === 'selesai')

                                            <span
                                                class="inline-flex items-center
                                                       px-3 py-1 rounded-full
                                                       bg-green-100 dark:bg-green-900/30
                                                       text-green-700 dark:text-green-400
                                                       text-xs font-semibold"
                                            >
                                                Selesai
                                            </span>

                                        @elseif($complaint->status === 'ditolak')

                                            <span
                                                class="inline-flex items-center
                                                       px-3 py-1 rounded-full
                                                       bg-red-100 dark:bg-red-900/30
                                                       text-red-700 dark:text-red-400
                                                       text-xs font-semibold"
                                            >
                                                Ditolak
                                            </span>

                                        @endif

                                    </td>


                                    <!-- AKSI -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="flex items-center justify-center gap-2">

                                            <!-- DETAIL -->
                                            <a
                                                href="{{ route('complaints.show', $complaint->id) }}"
                                                class="inline-flex items-center
                                                       px-3 py-2
                                                       rounded-md
                                                       bg-indigo-600
                                                       hover:bg-indigo-700
                                                       text-white
                                                       text-sm font-semibold
                                                       transition duration-150"
                                            >
                                                Detail
                                            </a>


                                            <!-- TINDAK LANJUT -->
                                            @if($complaint->status === 'diproses')

                                                <a
                                                    href="{{ route('complaints.resolve', $complaint->id) }}"
                                                    class="inline-flex items-center
                                                           px-3 py-2
                                                           rounded-md
                                                           bg-green-600
                                                           hover:bg-green-700
                                                           text-white
                                                           text-sm font-semibold
                                                           transition duration-150"
                                                >
                                                    Tindak Lanjut
                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-10 text-center"
                                    >

                                        <div class="text-gray-500 dark:text-gray-400">

                                            <p class="text-sm font-medium">
                                                Tidak ada aduan keuangan
                                            </p>

                                            <p class="text-xs mt-1">
                                                Belum ada aduan yang perlu ditangani.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- PAGINATION -->
                @if($complaints->hasPages())

                    <div
                        class="px-6 py-4
                               bg-gray-50 dark:bg-gray-700/30
                               border-t border-gray-200 dark:border-gray-700"
                    >
                        {{ $complaints->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
