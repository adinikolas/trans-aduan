<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Master Kategori Aduan
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola kategori dan divisi penanganan aduan.
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-[#C8102E] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#C8102E]/20 transition hover:bg-[#A50D25]">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Terdapat kesalahan:</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        Daftar Kategori
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Kategori aktif tersedia pada formulir pembuatan aduan pengguna.
                    </p>
                </div>

                @if ($categories->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">
                            Belum Ada Kategori
                        </h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Silakan tambahkan kategori aduan pertama.
                        </p>

                        <a href="{{ route('categories.create') }}"
                            class="mt-5 inline-flex rounded-lg bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-800">
                            Buat Kategori Pertama
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/40">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Divisi Penanganan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($categories as $category)
                                    <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $category->name }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $category->division->name ?? '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if ($category->is_active)
                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">

                                                <a href="{{ route('categories.edit', $category) }}"
                                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Edit
                                                </a>

                                                <form action="{{ route('categories.toggle-status', $category) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin {{ $category->is_active ? 'menonaktifkan' : 'mengaktifkan' }} kategori ini?')">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                        class="rounded-lg border px-3 py-2 text-xs font-semibold transition
                                                        {{ $category->is_active
                                                            ? 'border-red-200 text-red-700 hover:bg-red-50'
                                                            : 'border-green-200 text-green-700 hover:bg-green-50' }}">
                                                        {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                        {{ $categories->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
