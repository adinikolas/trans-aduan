<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Berita
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Perbarui informasi dan status publikasi berita.
                </p>
            </div>

            <a
                href="{{ route('news.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg
                    border border-gray-300 dark:border-gray-600
                    px-4 py-2 text-sm font-semibold
                    text-gray-700 dark:text-gray-200
                    hover:bg-gray-100 dark:hover:bg-gray-700
                    transition"
            >
                <span aria-hidden="true">←</span>
                Kembali
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

                <form action="{{ route('news.update', $news) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Judul Berita <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $news->title) }}" required maxlength="255"
                            placeholder="Masukkan judul berita"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Isi Berita <span class="text-red-600">*</span>
                        </label>
                        <textarea id="content" name="content" rows="10" required
                            placeholder="Tuliskan isi berita di sini..."
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Isi berita disimpan sebagai teks biasa.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Gambar Saat Ini
                        </label>

                        @if ($news->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $news->image) }}"
                                    alt="{{ $news->title }}"
                                    class="max-h-64 w-auto rounded-xl border border-gray-200 object-cover dark:border-gray-700">
                            </div>
                        @else
                            <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                                Belum ada gambar untuk berita ini.
                            </p>
                        @endif

                        <label for="image" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            {{ $news->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                        </label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full cursor-pointer rounded-xl border border-gray-300 bg-white text-sm text-gray-600 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:font-semibold file:text-gray-700 hover:file:bg-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-100">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Opsional, maksimal 2 MB. Kosongkan jika ingin mempertahankan gambar saat ini.
                        </p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Status Publikasi <span class="text-red-600">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-red-600 focus:ring-2 focus:ring-red-100 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                            <option value="draft"
                                {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>
                                Draft — Belum ditampilkan
                            </option>
                            <option value="published"
                                {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>
                                Published — Ditampilkan kepada pengguna
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 dark:border-gray-700 sm:flex-row sm:justify-between">
                        <div class="flex flex-col-reverse gap-3 sm:flex-row">
                            <a href="{{ route('news.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                Batal
                            </a>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
