<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Aduan Operasional
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Daftar laporan yang sedang ditangani oleh Manager Operasional.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Daftar Aduan
                    </h1>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Aduan yang masuk ke bidang operasional.
                    </p>
                </div>

                <a
                    href="{{ route('manager.operasional') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-md transition"
                >
                    ← Dashboard
                </a>

            </div>


            {{-- SEARCH & FILTER --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

                <form
                    method="GET"
                    action="{{ route('manager.operasional.aduan') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4"
                >

                    {{-- Search --}}
                    <div class="md:col-span-2">

                        <label
                            for="search"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        >
                            Cari Aduan
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="No. tiket atau judul laporan..."
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >

                    </div>


                    {{-- Status --}}
                    <div>

                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        >
                            Status
                        </label>

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

                            <option
                                value="selesai"
                                {{ request('status') === 'selesai' ? 'selected' : '' }}
                            >
                                Selesai
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md shadow-sm transition"
                        >
                            Terapkan
                        </button>

                        @if(request('search') || request('status'))

                            <a
                                href="{{ route('manager.operasional.aduan') }}"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-md transition"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </div>


            {{-- TABLE --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">

                <div class="overflow-x-auto">

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
                                    Jenis Aduan
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Judul
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

                                    {{-- Ticket --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $complaint->ticket_number }}
                                        </span>

                                    </td>


                                    {{-- Pelapor --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $complaint->user->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $complaint->user->email }}
                                        </div>

                                    </td>


                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $complaint->category->name }}
                                        </span>

                                    </td>


                                    {{-- Judul --}}
                                    <td class="px-6 py-4">

                                        <div
                                            class="text-sm font-medium text-gray-900 dark:text-gray-100 max-w-xs truncate"
                                            title="{{ $complaint->title }}"
                                        >
                                            {{ $complaint->title }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $complaint->created_at->format('d M Y H:i') }}
                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        @if($complaint->status === 'diproses')

                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                Diproses
                                            </span>

                                        @elseif($complaint->status === 'menunggu_validasi_cc')

                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                                Menunggu Validasi CC
                                            </span>

                                        @elseif($complaint->status === 'selesai')

                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Selesai
                                            </span>

                                        @else

                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                {{ ucfirst($complaint->status) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">

                                        <div class="flex items-center justify-center gap-3">

                                            <a
                                                href="{{ route('complaints.show', $complaint->id) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm font-semibold transition"
                                            >
                                                Detail
                                            </a>

                                            @if(
                                                in_array(
                                                    $complaint->status,
                                                    ['diproses', 'menunggu_validasi_cc']
                                                )
                                            )

                                                <a
                                                    href="{{ route('complaints.resolve', $complaint->id) }}"
                                                    class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-semibold transition"
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
                                        class="px-6 py-12 text-center"
                                    >

                                        <div class="text-4xl mb-3">
                                            📭
                                        </div>

                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            Tidak ada aduan operasional
                                        </p>

                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
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

                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">

                        {{ $complaints->links() }}

                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>
