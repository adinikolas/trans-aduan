<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">

            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white sm:text-2xl">
                    Tindak Lanjut Aduan
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $complaint->ticket_number }}
                </p>
            </div>

            <a
                href="{{ route('complaints.show', $complaint->id) }}"
                class="hidden text-sm font-medium text-gray-500 transition hover:text-gray-900
                       dark:text-gray-400 dark:hover:text-white sm:block"
            >
                ← Kembali
            </a>

        </div>
    </x-slot>


    <div class="py-8 sm:py-10">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- ========================================================= --}}
            {{-- INFORMASI ADUAN --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-2xl border border-gray-200
                        bg-white shadow-sm
                        dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-200 px-5 py-5
                            dark:border-gray-700">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider
                                      text-gray-500 dark:text-gray-400">
                                Judul Laporan
                            </p>

                            <h1 class="mt-1 text-xl font-bold text-gray-900 dark:text-white">
                                {{ $complaint->title }}
                            </h1>

                        </div>


                        {{-- STATUS --}}
                        @if($complaint->status === 'diproses')

                            <span class="inline-flex w-fit rounded-full
                                         bg-blue-100 px-3 py-1 text-xs font-semibold
                                         text-blue-700
                                         dark:bg-blue-900/30 dark:text-blue-400">
                                Sedang Ditangani
                            </span>

                        @elseif($complaint->status === 'menunggu_validasi_cc')

                            <span class="inline-flex w-fit rounded-full
                                         bg-purple-100 px-3 py-1 text-xs font-semibold
                                         text-purple-700
                                         dark:bg-purple-900/30 dark:text-purple-400">
                                Menunggu Validasi CC
                            </span>

                        @endif

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-5 px-5 py-6 sm:grid-cols-2">

                    {{-- TICKET --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            Nomor Tiket
                        </p>

                        <p class="mt-1 font-semibold text-red-600 dark:text-red-400">
                            {{ $complaint->ticket_number }}
                        </p>

                    </div>


                    {{-- PELAPOR --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            Pelapor
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->user->name }}
                        </p>

                    </div>


                    {{-- KATEGORI --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            Kategori
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->category->name }}
                        </p>

                    </div>


                    {{-- DIVISI --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            Divisi Penanganan
                        </p>

                        @if($complaint->division)

                            <span class="mt-1 inline-flex rounded-full
                                         bg-indigo-100 px-3 py-1 text-xs font-semibold
                                         text-indigo-700
                                         dark:bg-indigo-900/30 dark:text-indigo-400">
                                {{ $complaint->division->name }}
                            </span>

                        @else

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Belum ditentukan
                            </p>

                        @endif

                    </div>


                    {{-- WAKTU --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            Waktu Kejadian
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($complaint->incident_time)->format('d M Y, H:i') }}
                        </p>

                    </div>


                    {{-- BUS --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-gray-500 dark:text-gray-400">
                            No. Lambung Bus
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $complaint->bus_number ?: '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- DESKRIPSI LAPORAN --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-2xl border border-gray-200
                        bg-white shadow-sm
                        dark:border-gray-700 dark:bg-gray-800">

                <div class="px-5 py-5">

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Deskripsi Laporan
                    </h3>

                    <div class="mt-4 rounded-xl border border-gray-200
                                bg-gray-50 p-4 text-sm leading-6 text-gray-700
                                dark:border-gray-700 dark:bg-gray-900
                                dark:text-gray-300">
                        {{ $complaint->description }}
                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- BUKTI PELAPOR --}}
            {{-- ========================================================= --}}

            @if($complaint->evidence_path)

                <div class="mb-6 overflow-hidden rounded-2xl border border-gray-200
                            bg-white shadow-sm
                            dark:border-gray-700 dark:bg-gray-800">

                    <div class="px-5 py-5">

                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Bukti Pelapor
                        </h3>

                        <a
                            href="{{ asset('storage/' . $complaint->evidence_path) }}"
                            target="_blank"
                            class="mt-4 block"
                        >
                            <img
                                src="{{ asset('storage/' . $complaint->evidence_path) }}"
                                alt="Bukti laporan"
                                class="max-h-[500px] w-full rounded-xl border
                                       border-gray-200 object-contain
                                       dark:border-gray-700"
                            >
                        </a>

                        <p class="mt-2 text-xs italic text-gray-500 dark:text-gray-400">
                            Klik gambar untuk melihat ukuran penuh.
                        </p>

                    </div>

                </div>

            @endif


            {{-- ========================================================= --}}
            {{-- FORM TINDAK LANJUT --}}
            {{-- ========================================================= --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200
                        bg-white shadow-sm
                        dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-200 px-5 py-5
                            dark:border-gray-700">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center
                                    rounded-xl bg-green-100 text-xl
                                    dark:bg-green-900/30">
                            ✓
                        </div>

                        <div>

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Hasil Tindak Lanjut
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Isi hasil pemeriksaan dan tindakan yang telah dilakukan.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route('complaints.store_resolution', $complaint->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-5"
                >

                    @csrf
                    @method('PUT')


                    {{-- ERROR --}}
                    @if($errors->any())

                        <div class="mb-6 rounded-xl border border-red-200
                                    bg-red-50 p-4
                                    dark:border-red-900 dark:bg-red-900/20">

                            <p class="font-semibold text-red-800 dark:text-red-300">
                                Terdapat kesalahan pada data.
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm
                                       text-red-700 dark:text-red-400">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- CATATAN --}}
                    <div class="mb-6">

                        <label
                            for="resolution_notes"
                            class="mb-2 block text-sm font-semibold
                                   text-gray-700 dark:text-gray-300"
                        >
                            Catatan Tindak Lanjut
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            name="resolution_notes"
                            id="resolution_notes"
                            rows="7"
                            required
                            placeholder="Jelaskan hasil pemeriksaan, tindakan yang dilakukan, dan hasil penanganannya..."
                            class="block w-full rounded-xl border-gray-300
                                   bg-white text-gray-900 shadow-sm
                                   focus:border-green-500 focus:ring-green-500
                                   dark:border-gray-600 dark:bg-gray-900
                                   dark:text-gray-200 dark:placeholder-gray-500"
                        >{{ old('resolution_notes', $complaint->resolution_notes) }}</textarea>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Jelaskan tindakan secara jelas karena catatan ini
                            akan diperiksa oleh CC Room.
                        </p>

                    </div>


                    {{-- BUKTI PENYELESAIAN --}}
                    <div class="mb-6">

                        <label
                            for="resolution_proof"
                            class="mb-2 block text-sm font-semibold
                                   text-gray-700 dark:text-gray-300"
                        >
                            Bukti Penyelesaian
                            <span class="text-gray-400">(opsional)</span>
                        </label>

                        <input
                            type="file"
                            name="resolution_proof"
                            id="resolution_proof"
                            accept="image/jpeg,image/png,image/jpg"
                            class="block w-full rounded-xl border border-gray-300
                                   bg-white text-sm text-gray-700
                                   file:mr-4 file:rounded-lg file:border-0
                                   file:bg-gray-100 file:px-4 file:py-2
                                   file:text-sm file:font-semibold
                                   file:text-gray-700
                                   hover:file:bg-gray-200
                                   dark:border-gray-600 dark:bg-gray-900
                                   dark:text-gray-300
                                   dark:file:bg-gray-700
                                   dark:file:text-gray-200"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Format JPG, JPEG, atau PNG. Maksimal 5 MB.
                        </p>

                        @if($complaint->resolution_proof_path)

                            <div class="mt-4 rounded-xl border border-green-200
                                        bg-green-50 p-4
                                        dark:border-green-900
                                        dark:bg-green-900/20">

                                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                    Bukti penyelesaian saat ini:
                                </p>

                                <a
                                    href="{{ asset('storage/' . $complaint->resolution_proof_path) }}"
                                    target="_blank"
                                    class="mt-2 inline-block text-sm font-semibold
                                           text-green-700 hover:underline
                                           dark:text-green-400"
                                >
                                    Lihat bukti yang sudah diunggah →
                                </a>

                            </div>

                        @endif

                    </div>


                    {{-- INFO STATUS --}}
                    <div class="mb-6 rounded-xl border border-blue-200
                                bg-blue-50 p-4
                                dark:border-blue-900 dark:bg-blue-900/20">

                        <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">
                            Setelah dikirim
                        </p>

                        <p class="mt-1 text-sm leading-6 text-blue-700 dark:text-blue-400">
                            Status aduan akan berubah menjadi
                            <strong>Menunggu Validasi CC</strong>.
                            CC Room akan memeriksa hasil tindak lanjut sebelum
                            tiket dinyatakan selesai.
                        </p>

                    </div>


                    {{-- BUTTON --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('complaints.show', $complaint->id) }}"
                            class="inline-flex items-center justify-center rounded-xl
                                   border border-gray-300 px-5 py-2.5
                                   text-sm font-semibold text-gray-700
                                   transition hover:bg-gray-50
                                   dark:border-gray-600 dark:text-gray-300
                                   dark:hover:bg-gray-700"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl
                                   bg-green-600 px-5 py-2.5
                                   text-sm font-semibold text-white shadow-sm
                                   transition hover:bg-green-700
                                   focus:outline-none focus:ring-2
                                   focus:ring-green-500 focus:ring-offset-2"
                        >
                            Kirim Hasil Tindak Lanjut
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
