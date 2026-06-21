<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tindak Lanjut Aduan: ') }} {{ $complaint->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-50 dark:bg-gray-800 border-l-4 border-blue-500 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-2">Masalah yang Dilaporkan:</h3>
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $complaint->description }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4">Laporan Penyelesaian Lapangan</h3>
                    
                    <form action="{{ route('complaints.store_resolution', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="resolution_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Perbaikan / Resolusi</label>
                            <textarea name="resolution_notes" id="resolution_notes" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Jelaskan tindakan apa saja yang sudah dilakukan oleh tim lapangan..."></textarea>
                            @error('resolution_notes') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="resolution_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unggah Foto Bukti Penyelesaian</label>
                            <input type="file" name="resolution_proof" id="resolution_proof" accept="image/*" required
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 dark:file:bg-green-900/30 file:text-green-700 dark:file:text-green-400 hover:file:bg-green-100 dark:hover:file:bg-green-900/50">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG. Maksimal 2MB. Pastikan foto memperlihatkan hasil yang sudah diperbaiki.</p>
                            @error('resolution_proof') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('complaints.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-medium mr-4 transition">Batal</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                                Kirim Bukti Penyelesaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>