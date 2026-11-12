<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Kategori
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Tambahkan jenis aduan dan tentukan divisi penanganannya.
                </p>
            </div>

            <a href="{{ route('categories.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="font-semibold">Terdapat kesalahan pada input:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Nama Kategori <span class="text-red-600">*</span>
                        </label>

                        <input type="text" id="name" name="name"
                            value="{{ old('name') }}" required maxlength="255"
                            placeholder="Contoh: Kondisi Armada"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="division_id" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Divisi Penanganan <span class="text-red-600">*</span>
                        </label>

                        <select id="division_id" name="division_id" required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                            <option value="">Pilih Divisi</option>

                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('division_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Divisi ini akan menjadi tujuan penanganan otomatis berdasarkan kategori.
                        </p>
                    </div>

                    <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900 dark:bg-green-900/20 dark:text-green-300">
                        Kategori baru akan langsung berstatus Aktif dan tersedia pada formulir aduan pengguna.
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 dark:border-gray-700 sm:flex-row sm:justify-end">
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                            Batal
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Simpan Kategori
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
