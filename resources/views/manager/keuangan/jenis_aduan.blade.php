<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Jenis Aduan Keuangan
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Rekapitulasi aduan berdasarkan jenis permasalahan keuangan.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Jenis Aduan
                    </h1>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Statistik aduan berdasarkan kategori keuangan.
                    </p>
                </div>

                <a
                    href="{{ route('manager.keuangan') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-md transition"
                >
                    ← Dashboard
                </a>

            </div>


            {{-- SUMMARY CARDS --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Jenis Aduan
                    </p>

                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ $categoryStats->count() }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Aduan
                    </p>

                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ $categoryStats->sum('total_complaints') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sedang Diproses
                    </p>

                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                        {{ $categoryStats->sum('diproses_count') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Selesai
                    </p>

                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                        {{ $categoryStats->sum('selesai_count') }}
                    </p>
                </div>

            </div>


            {{-- TABLE --}}

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                        Rekap Berdasarkan Jenis Aduan
                    </h3>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Jenis Aduan
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Total
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Menunggu
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Diproses
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Validasi CC
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Selesai
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Ditolak
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($categoryStats as $category)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ $category->total_complaints }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-yellow-600 dark:text-yellow-400">
                                        {{ $category->menunggu_count }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-blue-600 dark:text-blue-400 font-semibold">
                                        {{ $category->diproses_count }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-purple-600 dark:text-purple-400 font-semibold">
                                        {{ $category->validasi_count }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-green-600 dark:text-green-400 font-semibold">
                                        {{ $category->selesai_count }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-red-600 dark:text-red-400 font-semibold">
                                        {{ $category->ditolak_count }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada jenis aduan.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
