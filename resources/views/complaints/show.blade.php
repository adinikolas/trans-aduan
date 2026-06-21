<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan: ') }} {{ $complaint->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4 text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Pelapor:</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $complaint->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Kategori:</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $complaint->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Waktu Kejadian:</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">No. Lambung Bus:</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $complaint->bus_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Deskripsi Laporan:</p>
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-sm text-gray-800 dark:text-gray-200 mt-1">
                        {{ $complaint->description }}
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Foto Bukti:</p>
                    
                    @if($complaint->evidence_path)
                        <img src="{{ asset('storage/' . $complaint->evidence_path) }}" alt="Bukti Kejadian" class="max-w-full h-auto rounded border dark:border-gray-700 shadow-sm">
                    @else
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-6 text-center border border-dashed border-gray-300 dark:border-gray-600">
                            <p class="text-gray-500 dark:text-gray-400 text-sm italic">
                                Pelapor tidak melampirkan foto bukti kejadian.
                            </p>
                        </div>
                    @endif
                </div>

                @if($complaint->resolution_notes)
                <div class="mt-8 border-t dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-bold text-green-700 dark:text-green-400 mb-4">Laporan Penyelesaian dari Kadiv</h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Catatan Perbaikan:</p>
                        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 p-4 rounded text-sm text-gray-800 dark:text-gray-200 mt-1">
                            {{ $complaint->resolution_notes }}
                        </div>
                    </div>

                    @if($complaint->resolution_proof_path)
                    <div class="mb-4">
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Foto Bukti Perbaikan:</p>
                        <img src="{{ asset('storage/' . $complaint->resolution_proof_path) }}" alt="Bukti Perbaikan" class="max-w-full h-auto rounded border dark:border-gray-700 shadow-sm">
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="w-full md:w-1/3 flex flex-col gap-6 self-start">
                
                @if(Auth::user()->role === 'cc_room')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4 text-gray-900 dark:text-gray-100">Tindakan CC Room</h3>
                    
                    <form action="{{ route('complaints.update', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubah Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="menunggu" {{ $complaint->status == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="diproses" {{ $complaint->status == 'diproses' ? 'selected' : '' }}>Valid & Disposisi (Diproses)</option>
                                <option value="selesai" {{ $complaint->status == 'menunggu_validasi_cc' ? 'selected' : '' }} class="font-bold text-green-600 dark:text-green-500">Validasi Selesai (Tutup Tiket)</option>
                                <option value="ditolak" {{ $complaint->status == 'ditolak' ? 'selected' : '' }}>Tolak / Spam</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disposisi ke Divisi</label>
                            <select name="division_id" id="division_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Divisi (Jika Valid) --</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ $complaint->division_id == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm transition">
                            Simpan & Teruskan
                        </button>
                    </form>
                </div>
                @endif
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-5 text-gray-900 dark:text-gray-100">Lacak Pergerakan Laporan</h3>
                    
                    <div class="relative border-l border-gray-200 dark:border-gray-700 ml-3">
                        @forelse($complaint->histories()->latest()->get() as $history)
                            <div class="mb-6 ml-5">
                                <div class="absolute w-3 h-3 bg-indigo-500 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-800"></div>
                                <time class="mb-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">
                                    {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y, H:i') }}
                                </time>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mt-1">
                                    {{ strtoupper(str_replace('_', ' ', $history->status)) }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $history->note }}
                                </p>
                            </div>
                        @empty
                            <div class="ml-5">
                                <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada riwayat pergerakan untuk tiket ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>