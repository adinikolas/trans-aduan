<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Laporan: ') }} {{ $complaint->ticket_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

            <!-- DETAIL LAPORAN -->
            <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4 text-gray-900 dark:text-gray-100">
                    {{ $complaint->title }}
                </h3>

                <!-- INFORMASI DASAR -->
                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Pelapor:
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->user->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Kategori:
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->category->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Divisi Penanganan:
                        </p>

                        @if($complaint->division)
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $complaint->division->name === 'Keuangan'
                                    ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                                    : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400' }}">
                                {{ $complaint->division->name }}
                            </span>
                        @else
                            <p class="font-semibold text-gray-500 dark:text-gray-400">
                                Belum didisposisikan
                            </p>
                        @endif
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Waktu Kejadian:
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            No. Lambung Bus:
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->bus_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            Status:
                        </p>

                        @if($complaint->status === 'menunggu')
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                Menunggu Verifikasi
                            </span>

                        @elseif($complaint->status === 'diproses')
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Diproses
                            </span>

                        @elseif($complaint->status === 'menunggu_validasi_cc')
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                Menunggu Validasi CC
                            </span>

                        @elseif($complaint->status === 'selesai')
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Selesai
                            </span>

                        @else
                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                Ditolak
                            </span>
                        @endif
                    </div>

                </div>

                <!-- DESKRIPSI -->
                <div class="mb-4">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Deskripsi Laporan:
                    </p>

                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-sm text-gray-800 dark:text-gray-200 mt-1">
                        {{ $complaint->description }}
                    </div>
                </div>

                <!-- BUKTI PELAPOR -->
                <div class="mb-4">

                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                        Foto Bukti Pelapor:
                    </p>

                    @if($complaint->evidence_path)

                        <a
                            href="{{ asset('storage/' . $complaint->evidence_path) }}"
                            target="_blank"
                        >
                            <img
                                src="{{ asset('storage/' . $complaint->evidence_path) }}"
                                alt="Bukti Kejadian"
                                class="max-w-full h-auto rounded border dark:border-gray-700 shadow-sm hover:opacity-90 transition"
                            >
                        </a>

                        <p class="text-xs text-gray-400 mt-1 italic">
                            *Klik gambar untuk memperbesar
                        </p>

                    @else

                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-6 text-center border border-dashed border-gray-300 dark:border-gray-600">
                            <p class="text-gray-500 dark:text-gray-400 text-sm italic">
                                Pelapor tidak melampirkan foto bukti kejadian.
                            </p>
                        </div>

                    @endif

                </div>

                <!-- HASIL TINDAK LANJUT -->
                @if($complaint->resolution_notes)

                    <div class="mt-8 border-t dark:border-gray-700 pt-6">

                        <h3 class="text-lg font-bold text-green-700 dark:text-green-400 mb-4">
                            Laporan Tindak Lanjut
                        </h3>

                        <div class="mb-4">

                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Catatan Tindak Lanjut:
                            </p>

                            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 p-4 rounded text-sm text-gray-800 dark:text-gray-200 mt-1">
                                {{ $complaint->resolution_notes }}
                            </div>

                        </div>

                        @if($complaint->resolution_proof_path)

                            <div class="mb-4">

                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                                    Foto Bukti Penyelesaian:
                                </p>

                                <a
                                    href="{{ asset('storage/' . $complaint->resolution_proof_path) }}"
                                    target="_blank"
                                    class="block"
                                >
                                    <img
                                        src="{{ asset('storage/' . $complaint->resolution_proof_path) }}"
                                        alt="Bukti Penyelesaian"
                                        class="max-w-full h-auto rounded border dark:border-gray-700 shadow-sm hover:opacity-90 transition"
                                    >
                                </a>

                                <p class="text-xs text-gray-400 mt-1 italic">
                                    *Klik gambar untuk memperbesar
                                </p>

                            </div>

                        @endif

                    </div>

                @endif

            </div>


            <!-- SIDEBAR -->
            <div class="w-full md:w-1/3 flex flex-col gap-6 self-start">

                <!-- ====================================================== -->
                <!-- TINDAKAN CC ROOM -->
                <!-- ====================================================== -->

                @if(Auth::user()->role === 'cc_room')

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                        <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4 text-gray-900 dark:text-gray-100">
                            Tindakan CC Room
                        </h3>

                        @if($complaint->status === 'menunggu')

                            <form
                                action="{{ route('complaints.update', $complaint->id) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PUT')

                                <div class="mb-5">

                                    <label
                                        for="status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Tindakan
                                    </label>

                                    <select
                                        name="status"
                                        id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >

                                        <option value="diproses">
                                            Valid & Teruskan
                                        </option>

                                        <option value="ditolak">
                                            Tolak / Tidak Valid
                                        </option>

                                    </select>

                                </div>

                                <!-- INFO DIVISI OTOMATIS -->
                                <div class="mb-6 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">

                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                        Divisi Tujuan
                                    </p>

                                    @if($complaint->category->division)

                                        <div class="mt-2 flex items-center gap-2">

                                            <span class="text-lg">
                                                {{ $complaint->category->division->name === 'Keuangan' ? '💰' : '⚙️' }}
                                            </span>

                                            <div>

                                                <p class="font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $complaint->category->division->name }}
                                                </p>

                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Ditentukan otomatis berdasarkan kategori laporan.
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                            Kategori ini belum memiliki divisi penanganan.
                                        </p>

                                    @endif

                                </div>

                                <button
                                    type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm transition"
                                >
                                    Simpan & Teruskan
                                </button>

                            </form>

                        @elseif($complaint->status === 'menunggu_validasi_cc')

                            <div class="rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 p-4 mb-4">

                                <p class="font-bold text-purple-800 dark:text-purple-300">
                                    Menunggu Validasi Akhir
                                </p>

                                <p class="text-sm text-purple-700 dark:text-purple-400 mt-1">
                                    Manager telah mengirimkan hasil tindak lanjut.
                                    Silakan periksa bukti penyelesaian sebelum menutup tiket.
                                </p>

                            </div>

                            <form
                                action="{{ route('complaints.update', $complaint->id) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="selesai"
                                >

                                <button
                                    type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition"
                                >
                                    ✓ Validasi & Tutup Tiket
                                </button>

                            </form>

                            <form
                                action="{{ route('complaints.update', $complaint->id) }}"
                                method="POST"
                                class="mt-2"
                            >

                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="diproses"
                                >

                                <button
                                    type="submit"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm transition"
                                >
                                    ↻ Kembalikan ke Manager
                                </button>

                            </form>

                        @elseif($complaint->status === 'selesai')

                            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">

                                <p class="font-bold text-green-800 dark:text-green-300">
                                    ✓ Tiket Selesai
                                </p>

                                <p class="text-sm text-green-700 dark:text-green-400 mt-1">
                                    Tiket telah divalidasi dan ditutup oleh CC Room.
                                </p>

                            </div>

                        @elseif($complaint->status === 'ditolak')

                            <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">

                                <p class="font-bold text-red-800 dark:text-red-300">
                                    Tiket Ditolak
                                </p>

                                <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                    Laporan telah ditolak oleh CC Room.
                                </p>

                            </div>

                        @else

                            <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-4">

                                <p class="font-bold text-blue-800 dark:text-blue-300">
                                    Sedang Diproses
                                </p>

                                <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                    Laporan telah diteruskan ke divisi terkait.
                                </p>

                            </div>

                        @endif

                    </div>

                @endif


                <!-- ====================================================== -->
                <!-- TINDAKAN MANAGER -->
                <!-- ====================================================== -->

                @if(in_array(Auth::user()->role, [
                    'manager_keuangan',
                    'manager_operasional'
                ]))

                    @php
                        $managerDivision =
                            Auth::user()->role === 'manager_keuangan'
                                ? 'Keuangan'
                                : 'Operasional';
                    @endphp

                    @if(
                        $complaint->division &&
                        $complaint->division->name === $managerDivision &&
                        in_array($complaint->status, [
                            'diproses',
                            'menunggu_validasi_cc'
                        ])
                    )

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                            <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-4 text-gray-900 dark:text-gray-100">
                                Tindak Lanjut
                            </h3>

                            @if($complaint->status === 'diproses')

                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    Aduan ini telah diteruskan kepada
                                    <strong>{{ $managerDivision }}</strong>.
                                    Silakan lakukan tindak lanjut.
                                </p>

                                <a
                                    href="{{ route('complaints.resolve', $complaint->id) }}"
                                    class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition"
                                >
                                    Tindak Lanjut Aduan
                                </a>

                            @else

                                <div class="rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 p-4">

                                    <p class="font-bold text-purple-800 dark:text-purple-300">
                                        Menunggu Validasi CC Room
                                    </p>

                                    <p class="text-sm text-purple-700 dark:text-purple-400 mt-1">
                                        Hasil tindak lanjut telah dikirim.
                                        Menunggu pemeriksaan dan validasi akhir dari CC Room.
                                    </p>

                                </div>

                            @endif

                        </div>

                    @endif

                @endif


                <!-- ====================================================== -->
                <!-- RIWAYAT -->
                <!-- ====================================================== -->

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <h3 class="text-lg font-bold border-b dark:border-gray-700 pb-2 mb-5 text-gray-900 dark:text-gray-100">
                        Lacak Pergerakan Laporan
                    </h3>

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

                                <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                                    Belum ada riwayat pergerakan untuk tiket ini.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
