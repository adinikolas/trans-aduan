<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Beri Ulasan untuk Tiket: ') }} {{ $complaint->ticket_number }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Bagikan penilaian Anda terhadap penanganan aduan.
                </p>
            </div>

            <a
                href="{{ route('complaints.show', $complaint->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg
                    border border-gray-300 dark:border-gray-600
                    px-4 py-2 text-sm font-semibold
                    text-gray-700 dark:text-gray-200
                    hover:bg-gray-100 dark:hover:bg-gray-700
                    transition"
            >
                <span aria-hidden="true">←</span>
                Kembali ke Detail Aduan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4">Penilaian Layanan</h3>

                    <form action="{{ route('complaints.store_feedback', $complaint->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Kepuasan (1-5 Bintang)</label>
                            <select name="rating" id="rating" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="" disabled selected>-- Pilih Penilaian --</option>
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Kurang Puas)</option>
                                <option value="1">⭐ (Sangat Kecewa)</option>
                            </select>
                            @error('rating') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komentar Tambahan (Opsional)</label>
                            <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Sampaikan saran atau apresiasi Anda..."></textarea>
                            @error('comment') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
