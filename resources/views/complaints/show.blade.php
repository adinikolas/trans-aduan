<x-app-layout>

    {{-- ============================================================
        HEADER
    ============================================================= --}}
    <x-slot name="header">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    Detail Laporan
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $complaint->ticket_number }}
                </p>
            </div>


            {{-- =================================================
                TOMBOL KEMBALI SESUAI ROLE
            ================================================== --}}

            @php
                $backRoute = match(Auth::user()->role) {
                    'manager_keuangan' => route('manager.keuangan.aduan'),
                    'manager_operasional' => route('manager.operasional.aduan'),
                    default => route('complaints.index'),
                };
            @endphp

            <a
                href="{{ $backRoute }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#C8102E] dark:text-gray-400 dark:hover:text-[#E21D3F]"
            >
                ← Kembali
            </a>

        </div>

    </x-slot>


    {{-- ============================================================
        CONTENT
    ============================================================= --}}
    <div class="py-6 sm:py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- ====================================================
                FLASH MESSAGE
            ===================================================== --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROR --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 dark:border-red-800 dark:bg-red-900/20">

                    <p class="text-sm font-semibold text-red-700 dark:text-red-400">
                        Terjadi kesalahan
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-600 dark:text-red-400">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- ====================================================
                LAYOUT UTAMA

                Desktop:
                kiri  = detail
                kanan = tindakan + riwayat

                Mobile:
                semuanya menjadi 1 kolom
            ===================================================== --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


                {{-- =================================================
                    KOLOM KIRI
                ================================================== --}}
                <div class="space-y-6 lg:col-span-2">


                    {{-- =================================================
                        INFORMASI LAPORAN
                    ================================================== --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">


                        {{-- HEADER CARD --}}
                        <div class="border-b border-gray-200 px-5 py-5 sm:px-6 dark:border-gray-800">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                        Judul Laporan
                                    </p>

                                    <h1 class="mt-1 break-words text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $complaint->title }}
                                    </h1>

                                </div>


                                {{-- STATUS --}}
                                <div class="shrink-0">

                                    @if($complaint->status === 'menunggu')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            Menunggu Verifikasi
                                        </span>

                                    @elseif($complaint->status === 'diproses')

                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            Diproses
                                        </span>

                                    @elseif($complaint->status === 'menunggu_validasi_cc')

                                        <span class="inline-flex rounded-full bg-purple-100 px-3 py-1.5 text-xs font-semibold text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            Validasi Akhir
                                        </span>

                                    @elseif($complaint->status === 'selesai')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            Ditolak
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- INFORMASI --}}
                        <div class="grid grid-cols-1 gap-x-8 gap-y-5 px-5 py-6 sm:grid-cols-2 sm:px-6">


                            {{-- PELAPOR --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Pelapor
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $complaint->user->name }}
                                </p>

                            </div>


                            {{-- KATEGORI --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Kategori
                                </p>

                                <p class="mt-1 break-words text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $complaint->category->name }}
                                </p>

                            </div>


                            {{-- DIVISI --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Divisi Penanganan
                                </p>

                                @if($complaint->division)

                                    <span
                                        class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{
                                            $complaint->division->name === 'Keuangan'
                                                ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                                                : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400'
                                        }}"
                                    >
                                        {{ $complaint->division->name }}
                                    </span>

                                @else

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Belum didisposisikan
                                    </p>

                                @endif

                            </div>


                            {{-- WAKTU --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Waktu Kejadian
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y, H:i') }}
                                </p>

                            </div>


                            {{-- BUS --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    No. Lambung Bus
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $complaint->bus_number ?: '-' }}
                                </p>

                            </div>


                            {{-- TIKET --}}
                            <div>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Nomor Tiket
                                </p>

                                <p class="mt-1 break-all text-sm font-bold text-[#C8102E] dark:text-[#E21D3F]">
                                    {{ $complaint->ticket_number }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        DESKRIPSI
                    ================================================== --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Deskripsi Laporan
                        </h3>

                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm leading-7 text-gray-700 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-300">

                            {!! nl2br(e($complaint->description)) !!}

                        </div>

                    </div>


                    {{-- =================================================
                        BUKTI PELAPOR
                    ================================================== --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Bukti Pelapor
                        </h3>

                        @if($complaint->evidence_path)

                            <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">

                                <a
                                    href="{{ asset('storage/' . $complaint->evidence_path) }}"
                                    target="_blank"
                                    class="block"
                                >

                                    <img
                                        src="{{ asset('storage/' . $complaint->evidence_path) }}"
                                        alt="Bukti laporan"
                                        class="max-h-[500px] w-full object-contain bg-gray-50 transition hover:opacity-90 dark:bg-gray-950"
                                    >

                                </a>

                            </div>

                            <p class="mt-2 text-xs italic text-gray-400">
                                Klik gambar untuk memperbesar.
                            </p>

                        @else

                            <div class="mt-4 flex min-h-[120px] items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 text-center dark:border-gray-700 dark:bg-gray-950">

                                <p class="text-sm italic text-gray-500 dark:text-gray-400">
                                    Pelapor tidak melampirkan foto bukti kejadian.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                        HASIL TINDAK LANJUT
                    ================================================== --}}
                    @if($complaint->resolution_notes)

                        <div class="rounded-2xl border border-green-200 bg-white p-5 shadow-sm sm:p-6 dark:border-green-900/50 dark:bg-gray-900">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-100 text-lg dark:bg-green-900/30">
                                    ✓
                                </div>

                                <div>

                                    <h3 class="font-bold text-green-700 dark:text-green-400">
                                        Hasil Tindak Lanjut
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Hasil penanganan dari Manager
                                    </p>

                                </div>

                            </div>


                            {{-- CATATAN --}}
                            <div class="mt-5">

                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                    Catatan Tindak Lanjut
                                </p>

                                <div class="mt-2 rounded-xl border border-green-200 bg-green-50 p-4 text-sm leading-7 text-gray-700 dark:border-green-900/50 dark:bg-green-950/30 dark:text-gray-300">

                                    {!! nl2br(e($complaint->resolution_notes)) !!}

                                </div>

                            </div>


                            {{-- BUKTI --}}
                            @if($complaint->resolution_proof_path)

                                <div class="mt-5">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Bukti Penyelesaian
                                    </p>

                                    <div class="mt-2 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">

                                        <a
                                            href="{{ asset('storage/' . $complaint->resolution_proof_path) }}"
                                            target="_blank"
                                            class="block"
                                        >

                                            <img
                                                src="{{ asset('storage/' . $complaint->resolution_proof_path) }}"
                                                alt="Bukti penyelesaian"
                                                class="max-h-[500px] w-full object-contain bg-gray-50 transition hover:opacity-90 dark:bg-gray-950"
                                            >

                                        </a>

                                    </div>

                                    <p class="mt-2 text-xs italic text-gray-400">
                                        Klik gambar untuk memperbesar.
                                    </p>

                                </div>

                            @endif

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    KOLOM KANAN
                ================================================== --}}
                <div class="space-y-6">


                    {{-- =================================================
                        TINDAKAN CC ROOM
                    ================================================== --}}
                    @if(Auth::user()->role === 'cc_room')

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                            <div class="flex items-center gap-3 border-b border-gray-200 pb-4 dark:border-gray-800">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#C8102E]/10 text-[#C8102E]">
                                    ✓
                                </div>

                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Tindakan CC Room
                                </h3>

                            </div>


                            {{-- MENUNGGU --}}
                            @if($complaint->status === 'menunggu')

                                <p class="mt-4 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                    Periksa laporan sebelum menentukan apakah laporan valid dan perlu diteruskan.
                                </p>


                                {{-- DIVISI --}}
                                <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-950">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Divisi Tujuan
                                    </p>

                                    @if($complaint->category->division)

                                        <div class="mt-3 flex items-center gap-3">

                                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#C8102E]/10">

                                                @if($complaint->category->division->name === 'Keuangan')
                                                    💰
                                                @else
                                                    ⚙️
                                                @endif

                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $complaint->category->division->name }}
                                                </p>

                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Berdasarkan kategori.
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                            Kategori belum memiliki divisi penanganan.
                                        </p>

                                    @endif

                                </div>


                                {{-- ACTION --}}
                                <form
                                    action="{{ route('complaints.update', $complaint->id) }}"
                                    method="POST"
                                    class="mt-5 space-y-2"
                                >

                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        name="status"
                                        value="diproses"
                                        class="w-full rounded-xl bg-[#C8102E] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#A50D25] focus:outline-none focus:ring-2 focus:ring-[#C8102E]/30"
                                    >
                                        ✓ Valid & Teruskan
                                    </button>

                                    <button
                                        type="submit"
                                        name="status"
                                        value="ditolak"
                                        class="w-full rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30"
                                    >
                                        Tolak Laporan
                                    </button>

                                </form>


                            {{-- VALIDASI AKHIR --}}
                            @elseif($complaint->status === 'menunggu_validasi_cc')

                                <div class="mt-4 rounded-xl border border-purple-200 bg-purple-50 p-4 dark:border-purple-900/50 dark:bg-purple-900/20">

                                    <p class="font-semibold text-purple-800 dark:text-purple-300">
                                        Menunggu Validasi Akhir
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-purple-700 dark:text-purple-400">
                                        Manager telah mengirimkan hasil tindak lanjut. Periksa catatan dan bukti penyelesaian.
                                    </p>

                                </div>


                                <form
                                    action="{{ route('complaints.update', $complaint->id) }}"
                                    method="POST"
                                    class="mt-5"
                                >

                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        name="status"
                                        value="selesai"
                                        class="w-full rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700"
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

                                    <button
                                        type="submit"
                                        name="status"
                                        value="diproses"
                                        class="w-full rounded-xl bg-yellow-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-yellow-600"
                                    >
                                        ↻ Kembalikan ke Manager
                                    </button>

                                </form>


                            {{-- SELESAI --}}
                            @elseif($complaint->status === 'selesai')

                                <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-900/50 dark:bg-green-900/20">

                                    <p class="font-semibold text-green-800 dark:text-green-300">
                                        ✓ Tiket Selesai
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-green-700 dark:text-green-400">
                                        Tiket telah divalidasi dan ditutup oleh CC Room.
                                    </p>

                                </div>


                            {{-- DITOLAK --}}
                            @elseif($complaint->status === 'ditolak')

                                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/20">

                                    <p class="font-semibold text-red-800 dark:text-red-300">
                                        Tiket Ditolak
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-red-700 dark:text-red-400">
                                        Laporan telah ditolak oleh CC Room.
                                    </p>

                                </div>


                            {{-- DIPROSES --}}
                            @else

                                <div class="mt-4 rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900/50 dark:bg-blue-900/20">

                                    <p class="font-semibold text-blue-800 dark:text-blue-300">
                                        Sedang Diproses
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-blue-700 dark:text-blue-400">
                                        Laporan telah diteruskan ke divisi terkait.
                                    </p>

                                </div>

                            @endif

                        </div>

                    @endif


                    {{-- =================================================
                        TINDAKAN MANAGER
                    ================================================== --}}
                    @if(in_array(Auth::user()->role, [
                        'manager_keuangan',
                        'manager_operasional'
                    ], true))

                        @php
                            $managerDivision = Auth::user()->role === 'manager_keuangan'
                                ? 'Keuangan'
                                : 'Operasional';
                        @endphp


                        @if(
                            $complaint->division &&
                            $complaint->division->name === $managerDivision &&
                            in_array($complaint->status, [
                                'diproses',
                                'menunggu_validasi_cc'
                            ], true)
                        )

                            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                                <div class="flex items-center gap-3 border-b border-gray-200 pb-4 dark:border-gray-800">

                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        ✓
                                    </div>

                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                        Tindak Lanjut
                                    </h3>

                                </div>


                                @if($complaint->status === 'diproses')

                                    <p class="mt-4 text-sm leading-6 text-gray-600 dark:text-gray-400">

                                        Aduan ini telah diteruskan kepada
                                        <strong class="text-gray-900 dark:text-gray-200">
                                            Manager {{ $managerDivision }}
                                        </strong>.

                                    </p>

                                    <a
                                        href="{{ route('complaints.resolve', $complaint->id) }}"
                                        class="mt-5 block w-full rounded-xl bg-green-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-green-700"
                                    >
                                        Tindak Lanjut Aduan
                                    </a>

                                @else

                                    <div class="mt-4 rounded-xl border border-purple-200 bg-purple-50 p-4 dark:border-purple-900/50 dark:bg-purple-900/20">

                                        <p class="font-semibold text-purple-800 dark:text-purple-300">
                                            Menunggu Validasi CC Room
                                        </p>

                                        <p class="mt-2 text-sm leading-6 text-purple-700 dark:text-purple-400">
                                            Hasil tindak lanjut telah dikirim dan sedang menunggu pemeriksaan CC Room.
                                        </p>

                                    </div>

                                @endif

                            </div>

                        @endif

                    @endif


                    {{-- =================================================
                        RIWAYAT
                    ================================================== --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                        <div class="flex items-center gap-3 border-b border-gray-200 pb-4 dark:border-gray-800">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                🕒
                            </div>

                            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                Riwayat Laporan
                            </h3>

                        </div>


                        <div class="relative mt-6 border-l border-gray-200 dark:border-gray-700">

                            @forelse($complaint->histories->sortByDesc('created_at') as $history)

                                <div class="relative mb-7 ml-5 last:mb-0">

                                    {{-- DOT --}}
                                    <div class="absolute -left-[26px] top-1 h-3 w-3 rounded-full border-2 border-white bg-[#C8102E] dark:border-gray-900">
                                    </div>


                                    {{-- DATE --}}
                                    <p class="text-xs text-gray-400">
                                        {{ $history->created_at->format('d M Y, H:i') }}
                                    </p>


                                    {{-- STATUS --}}
                                    <p class="mt-1 text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ strtoupper(str_replace('_', ' ', $history->status)) }}
                                    </p>


                                    {{-- NOTE --}}
                                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                        {{ $history->note }}
                                    </p>

                                </div>

                            @empty

                                <p class="ml-5 text-sm italic text-gray-500 dark:text-gray-400">
                                    Belum ada riwayat pergerakan untuk tiket ini.
                                </p>

                            @endforelse

                        </div>

                    </div>


                    {{-- =================================================
                        FEEDBACK PENGGUNA
                    ================================================== --}}
                    @if(
                        Auth::user()->role === 'pengguna' &&
                        $complaint->status === 'selesai'
                    )

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-800 dark:bg-gray-900">

                            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                Ulasan Laporan
                            </h3>

                            @if($complaint->feedback)

                                <div class="mt-4 rounded-xl bg-gray-50 p-4 dark:bg-gray-950">

                                    <div class="text-lg">
                                        {{ str_repeat('⭐', $complaint->feedback->rating) }}
                                    </div>

                                    @if($complaint->feedback->comment)

                                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                            "{{ $complaint->feedback->comment }}"
                                        </p>

                                    @endif

                                    <p class="mt-3 text-xs text-gray-400">
                                        Ulasan telah diberikan.
                                    </p>

                                </div>

                            @else

                                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                    Laporan telah selesai. Anda dapat memberikan ulasan terhadap penanganan laporan ini.
                                </p>

                                <a
                                    href="{{ route('complaints.feedback', $complaint->id) }}"
                                    class="mt-4 flex w-full items-center justify-center rounded-xl bg-[#C8102E] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#A50D25]"
                                >
                                    Beri Ulasan ⭐
                                </a>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
