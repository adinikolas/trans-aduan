<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard Manager Operasional
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Ringkasan aduan terkait armada, fasilitas, pengemudi, dan operasional layanan.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ========================================================= --}}
            {{-- HEADER DASHBOARD --}}
            {{-- ========================================================= --}}

            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Dashboard Operasional
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan data aduan dan penanganan bidang operasional.
                </p>
            </div>


            {{-- ========================================================= --}}
            {{-- STATISTIK --}}
            {{-- ========================================================= --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Total --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Aduan
                    </p>

                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ $totalAduan }}
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Seluruh aduan keuangan
                    </p>

                </div>


                {{-- Diproses --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Sedang Diproses
                    </p>

                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">
                        {{ $diproses }}
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Aduan sedang ditangani
                    </p>

                </div>


                {{-- Validasi CC --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Menunggu Validasi CC
                    </p>

                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">
                        {{ $menungguValidasi }}
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Menunggu pemeriksaan CC Room
                    </p>

                </div>


                {{-- Selesai --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Aduan Selesai
                    </p>

                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                        {{ $selesai }}
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Tiket telah diselesaikan
                    </p>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- GRAFIK + KATEGORI --}}
            {{-- ========================================================= --}}

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Grafik Bulanan --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

                    <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                            Grafik Aduan Bulanan
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Jumlah aduan dalam 6 bulan terakhir
                        </p>

                    </div>

                    <div class="p-5">
                        <canvas id="monthlyComplaintChart" height="180"></canvas>
                    </div>

                </div>


                {{-- Ringkasan Kategori --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

                    <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                            Aduan Berdasarkan Jenis
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Kategori aduan bidang keuangan
                        </p>

                    </div>

                    <div class="p-5">

                        @forelse($categoryStats as $category)

                            <div class="flex items-center justify-between py-3 border-b last:border-b-0 border-gray-100 dark:border-gray-700">

                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Diproses: {{ $category->diproses_count }}
                                        · Validasi CC: {{ $category->validasi_count }}
                                        · Selesai: {{ $category->selesai_count }}
                                    </p>
                                </div>

                                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $category->total_complaints }}
                                </span>

                            </div>

                        @empty

                            <div class="text-center py-8">

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data kategori.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- TABEL REKAP KATEGORI --}}
            {{-- ========================================================= --}}

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                        Rekap Aduan Berdasarkan Kategori
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
                                    Diproses
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Validasi CC
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Selesai
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse($categoryStats as $category)

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                        {{ $category->total_complaints }}
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

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada data aduan.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- REKAP BULANAN --}}
            {{-- ========================================================= --}}

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                        Rekap Aduan per Bulan
                    </h3>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Bulan
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Total Aduan
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach($monthlyStats as $month)

                                <tr>

                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $month['label'] }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $month['total'] }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- CHART.JS --}}
    {{-- ========================================================= --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const monthlyLabels = @json(
            $monthlyStats->pluck('label')->values()
        );

        const monthlyTotals = @json(
            $monthlyStats->pluck('total')->values()
        );

        const ctx = document
            .getElementById('monthlyComplaintChart')
            .getContext('2d');

        new Chart(ctx, {
            type: 'bar',

            data: {
                labels: monthlyLabels,

                datasets: [{
                    label: 'Jumlah Aduan',
                    data: monthlyTotals,
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,

                plugins: {
                    legend: {
                        display: true
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

    </script>

</x-app-layout>
