<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tindak Lanjut Aduan: ') }} {{ $complaint->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- BARIS INI YANG DIUBAH MENJADI max-w-7xl -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Kotak Informasi Masalah (Sesuai Screenshot Anda) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-2">Masalah yang Dilaporkan:</h3>
                    <p class="font-semibold">{{ $complaint->title }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $complaint->description }}</p>
                </div>
            </div>

            <!-- Form Laporan Penyelesaian -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b dark:border-gray-700 pb-2">Laporan Penyelesaian Lapangan</h3>

                    <form action="{{ route('complaints.store_resolve', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Textarea Catatan Perbaikan -->
                        <div class="mb-6">
                            <label for="resolution_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Perbaikan / Resolusi</label>
                            <textarea name="resolution_notes" id="resolution_notes" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Jelaskan tindakan apa saja yang sudah dilakukan oleh tim lapangan..." required></textarea>
                        </div>

                        <!-- Input File Foto Bukti -->
                        <div class="mb-6">
                            <label for="resolution_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unggah Foto Bukti Penyelesaian</label>
                            <input type="file" name="resolution_proof" id="resolution_proof" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 transition" accept="image/jpeg, image/png, image/jpg" required>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG. Maksimal 2MB. Pastikan foto memperlihatkan hasil yang sudah diperbaiki.</p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end gap-4 mt-8">
                            <a href="{{ route('complaints.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-md shadow-sm transition">
                                Kirim Bukti Penyelesaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
