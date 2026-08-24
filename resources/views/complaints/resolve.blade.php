<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tindak Lanjut Aduan: ') }} {{ $complaint->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Laporan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-bold">
                                Laporan yang Ditangani
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Nomor Tiket:
                                <span class="font-semibold">
                                    {{ $complaint->ticket_number }}
                                </span>
                            </p>
                        </div>

                        @if(Auth::user()->role === 'manager_keuangan')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Manager Keuangan
                            </span>
                        @elseif(Auth::user()->role === 'manager_operasional')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">
                                Manager Operasional
                            </span>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->title }}
                        </h4>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                            {{ $complaint->description }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Form Penyelesaian -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-bold mb-4 border-b dark:border-gray-700 pb-2">
                        Laporan Tindak Lanjut
                    </h3>

                    <form
                        action="{{ route('complaints.store_resolution', $complaint->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label
                                for="resolution_notes"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Catatan Tindak Lanjut / Resolusi
                            </label>

                            <textarea
                                name="resolution_notes"
                                id="resolution_notes"
                                rows="5"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Jelaskan tindakan atau penyelesaian yang telah dilakukan..."
                                required
                            >{{ old('resolution_notes') }}</textarea>

                            <x-input-error
                                :messages="$errors->get('resolution_notes')"
                                class="mt-2"
                            />
                        </div>

                        <!-- Bukti -->
                        <div class="mb-6">
                            <label
                                for="resolution_proof"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Unggah Foto Bukti Penyelesaian
                            </label>

                            <input
                                type="file"
                                name="resolution_proof"
                                id="resolution_proof"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 transition"
                                accept="image/jpeg, image/png, image/jpg"
                                required
                            >

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Format: JPG, PNG. Maksimal 2MB.
                                Pastikan foto menunjukkan hasil tindak lanjut.
                            </p>

                            <x-input-error
                                :messages="$errors->get('resolution_proof')"
                                class="mt-2"
                            />
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center justify-end gap-4 mt-8">

                            <a
                                href="{{ route('complaints.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-md shadow-sm transition"
                            >
                                Kirim Tindak Lanjut
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
