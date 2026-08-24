<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintHistory;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Menampilkan dashboard sesuai role user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | 1. PENGGUNA UMUM
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'pengguna') {
            $complaints = Complaint::with([
                    'category',
                    'division'
                ])
                ->where('user_id', $user->id)
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ticket_number', 'like', '%' . $search . '%')
                            ->orWhere('title', 'like', '%' . $search . '%');
                    });
                })
                ->when($request->status, function ($query, $status) {
                    $query->where('status', $status);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view(
                'complaints.index_pengguna',
                compact('complaints')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. CC ROOM
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'cc_room') {

            $totalAduan = Complaint::count();

            $menunggu = Complaint::where(
                'status',
                'menunggu'
            )->count();

            $diproses = Complaint::whereIn(
                'status',
                ['diproses', 'menunggu_validasi_cc']
            )->count();

            $selesai = Complaint::where(
                'status',
                'selesai'
            )->count();

            $complaints = Complaint::with([
                    'user',
                    'category',
                    'division'
                ])
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ticket_number', 'like', '%' . $search . '%')
                            ->orWhere('title', 'like', '%' . $search . '%');
                    });
                })
                ->when($request->status, function ($query, $status) {
                    $query->where('status', $status);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view(
                'complaints.index_cc',
                compact(
                    'complaints',
                    'totalAduan',
                    'menunggu',
                    'diproses',
                    'selesai'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. MANAGER KEUANGAN
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'manager_keuangan') {

            $keuangan = Division::where(
                'name',
                'Keuangan'
            )->firstOrFail();

            $complaints = Complaint::with([
                    'user',
                    'category',
                    'division'
                ])
                ->where(
                    'division_id',
                    $keuangan->id
                )
                ->whereIn(
                    'status',
                    ['diproses', 'menunggu_validasi_cc']
                )
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ticket_number', 'like', '%' . $search . '%')
                            ->orWhere('title', 'like', '%' . $search . '%');
                    });
                })
                ->when($request->status, function ($query, $status) {
                    $query->where('status', $status);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view(
                'complaints.index_manager_keuangan',
                compact('complaints')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. MANAGER OPERASIONAL
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'manager_operasional') {

            $operasional = Division::where(
                'name',
                'Operasional'
            )->firstOrFail();

            $complaints = Complaint::with([
                    'user',
                    'category',
                    'division'
                ])
                ->where(
                    'division_id',
                    $operasional->id
                )
                ->whereIn(
                    'status',
                    ['diproses', 'menunggu_validasi_cc']
                )
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('ticket_number', 'like', '%' . $search . '%')
                            ->orWhere('title', 'like', '%' . $search . '%');
                    });
                })
                ->when($request->status, function ($query, $status) {
                    $query->where('status', $status);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view(
                'complaints.index_manager_operasional',
                compact('complaints')
            );
        }

        abort(403, 'Akses tidak diizinkan.');
    }


    /**
     * Menampilkan formulir pembuatan aduan.
     * Hanya pengguna umum.
     */
    public function create()
    {
        if (Auth::user()->role !== 'pengguna') {
            abort(
                403,
                'Hanya pengguna umum yang dapat membuat aduan.'
            );
        }

        $categories = Category::with('division')
            ->orderBy('division_id')
            ->orderBy('name')
            ->get();

        return view(
            'complaints.create',
            compact('categories')
        );
    }


    /**
     * Menyimpan data aduan baru.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pengguna') {
            abort(
                403,
                'Hanya pengguna umum yang dapat membuat aduan.'
            );
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'incident_time' => 'required|date',
            'bus_number' => 'nullable|string|max:50',
            'description' => 'required|string',
            'evidence' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'evidence.image' =>
                'File bukti harus berupa gambar.',

            'evidence.max' =>
                'Ukuran foto maksimal adalah 2MB.',
        ]);

        $evidencePath = null;

        if ($request->hasFile('evidence')) {
            $evidencePath = $request
                ->file('evidence')
                ->store(
                    'evidence_files',
                    'public'
                );
        }

        $ticketNumber =
            'TKT-' .
            date('Ymd') .
            '-' .
            str_pad(
                rand(1, 9999),
                4,
                '0',
                STR_PAD_LEFT
            );

        Complaint::create([
            'ticket_number' => $ticketNumber,
            'user_id' => Auth::id(),
            'category_id' => $validatedData['category_id'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'incident_time' => $validatedData['incident_time'],
            'bus_number' =>
                $validatedData['bus_number'] ?? null,
            'evidence_path' => $evidencePath,
            'status' => 'menunggu',
            'division_id' => null,
        ]);

        return redirect()
            ->route('complaints.index')
            ->with(
                'success',
                'Laporan aduan berhasil dikirim dengan Nomor Tiket: ' .
                $ticketNumber
            );
    }


    /**
     * Menampilkan detail aduan.
     */
    public function show($id)
    {
        $complaint = Complaint::with([
            'user',
            'category',
            'division'
        ])->findOrFail($id);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Pengguna hanya boleh melihat aduannya sendiri
        |--------------------------------------------------------------------------
        */
        if (
            $user->role === 'pengguna' &&
            $complaint->user_id !== $user->id
        ) {
            abort(
                403,
                'Anda tidak memiliki hak akses untuk melihat laporan ini.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CC Room boleh melihat semua aduan
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'cc_room') {

            $divisions = Division::all();

            return view(
                'complaints.show',
                compact(
                    'complaint',
                    'divisions'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Manager hanya boleh melihat aduan divisinya
        |--------------------------------------------------------------------------
        */
        if (
            in_array(
                $user->role,
                [
                    'manager_keuangan',
                    'manager_operasional'
                ],
                true
            )
        ) {

            $divisionName =
                $user->role === 'manager_keuangan'
                    ? 'Keuangan'
                    : 'Operasional';

            $division = Division::where(
                'name',
                $divisionName
            )->firstOrFail();

            if (
                $complaint->division_id !==
                $division->id
            ) {
                abort(
                    403,
                    'Anda tidak memiliki akses ke laporan divisi lain.'
                );
            }

            return view(
                'complaints.show',
                compact(
                    'complaint'
                )
            );
        }

        abort(
            403,
            'Anda tidak memiliki akses ke laporan ini.'
        );
    }


    /**
     * Update status oleh CC Room.
     *
     * Division ditentukan OTOMATIS berdasarkan kategori.
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'cc_room') {
            abort(
                403,
                'Hanya CC Room yang dapat memperbarui status laporan.'
            );
        }

        $complaint = Complaint::with(
            'category'
        )->findOrFail($id);

        $validatedData = $request->validate([
            'status' =>
                'required|in:menunggu,diproses,ditolak,selesai',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tentukan divisi berdasarkan kategori
        |--------------------------------------------------------------------------
        */
        $divisionId = null;

        if ($validatedData['status'] === 'diproses') {

            $divisionId =
                $complaint->category->division_id;

            if (!$divisionId) {
                return back()->withErrors([
                    'status' =>
                        'Kategori laporan belum memiliki divisi penanganan.'
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */
        $complaint->update([
            'status' =>
                $validatedData['status'],

            'division_id' =>
                $divisionId,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Riwayat
        |--------------------------------------------------------------------------
        */
        if ($validatedData['status'] === 'diproses') {

            $divisionName =
                $complaint
                    ->category
                    ->division
                    ->name;

            $historyNote =
                'Laporan tervalidasi oleh CC Room. ' .
                'Laporan diteruskan secara otomatis ke ' .
                'Divisi ' .
                $divisionName .
                '.';

        } elseif (
            $validatedData['status'] === 'selesai'
        ) {

            $historyNote =
                'Bukti penyelesaian divalidasi oleh CC Room. ' .
                'Tiket dinyatakan selesai dan ditutup.';

        } elseif (
            $validatedData['status'] === 'ditolak'
        ) {

            $historyNote =
                'Laporan ditolak oleh CC Room (Tidak valid/Spam).';

        } else {

            $historyNote =
                'Status diperbarui oleh CC Room.';
        }

        ComplaintHistory::create([
            'complaint_id' =>
                $complaint->id,

            'status' =>
                $validatedData['status'],

            'note' =>
                $historyNote,

            'created_by' =>
                Auth::id(),
        ]);

        return redirect()
            ->route('complaints.index')
            ->with(
                'success',
                'Status laporan ' .
                $complaint->ticket_number .
                ' berhasil diperbarui.'
            );
    }


    /**
     * Menampilkan formulir tindak lanjut manager.
     */
    public function resolve($id)
    {
        $user = Auth::user();

        $allowedRoles = [
            'manager_keuangan',
            'manager_operasional',
        ];

        if (!in_array(
            $user->role,
            $allowedRoles,
            true
        )) {
            abort(
                403,
                'Hanya Manager yang dapat melakukan tindak lanjut.'
            );
        }

        $complaint = Complaint::with(
            'division'
        )->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Tentukan divisi manager
        |--------------------------------------------------------------------------
        */
        $divisionName =
            $user->role === 'manager_keuangan'
                ? 'Keuangan'
                : 'Operasional';

        $division = Division::where(
            'name',
            $divisionName
        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Security: manager hanya boleh menangani divisinya
        |--------------------------------------------------------------------------
        */
        if (
            $complaint->division_id !==
            $division->id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk menangani laporan divisi lain.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status harus dapat ditindaklanjuti
        |--------------------------------------------------------------------------
        */
        if (
            !in_array(
                $complaint->status,
                [
                    'diproses',
                    'menunggu_validasi_cc'
                ],
                true
            )
        ) {
            abort(
                403,
                'Laporan ini tidak dapat ditindaklanjuti.'
            );
        }

        return view(
            'complaints.resolve',
            compact('complaint')
        );
    }


    /**
     * Memproses tindak lanjut manager.
     */
    public function storeResolution(
        Request $request,
        $id
    ) {
        $user = Auth::user();

        $allowedRoles = [
            'manager_keuangan',
            'manager_operasional',
        ];

        if (!in_array(
            $user->role,
            $allowedRoles,
            true
        )) {
            abort(
                403,
                'Hanya Manager yang dapat mengirim tindak lanjut.'
            );
        }

        $complaint = Complaint::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security: pastikan manager menangani divisinya sendiri
        |--------------------------------------------------------------------------
        */
        $divisionName =
            $user->role === 'manager_keuangan'
                ? 'Keuangan'
                : 'Operasional';

        $division = Division::where(
            'name',
            $divisionName
        )->firstOrFail();

        if (
            $complaint->division_id !==
            $division->id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk menangani laporan divisi lain.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */
        $validatedData = $request->validate([
            'resolution_notes' =>
                'required|string',

            'resolution_proof' =>
                'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'resolution_proof.image' =>
                'File bukti perbaikan harus berupa gambar.',

            'resolution_proof.max' =>
                'Ukuran foto maksimal adalah 2MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan bukti
        |--------------------------------------------------------------------------
        */
        $proofPath = $request
            ->file('resolution_proof')
            ->store(
                'resolution_proofs',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */
        $complaint->update([
            'status' =>
                'menunggu_validasi_cc',

            'resolution_notes' =>
                $validatedData['resolution_notes'],

            'resolution_proof_path' =>
                $proofPath,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Riwayat
        |--------------------------------------------------------------------------
        */
        ComplaintHistory::create([
            'complaint_id' =>
                $complaint->id,

            'status' =>
                'menunggu_validasi_cc',

            'note' =>
                'Tindak lanjut telah dilakukan oleh ' .
                (
                    $user->role === 'manager_keuangan'
                        ? 'Manager Keuangan'
                        : 'Manager Operasional'
                ) .
                '. Menunggu validasi akhir dari CC Room.',

            'created_by' =>
                Auth::id(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        $route =
            $user->role === 'manager_keuangan'
                ? 'manager.keuangan'
                : 'manager.operasional';

        return redirect()
            ->route($route)
            ->with(
                'success',
                'Bukti penyelesaian tiket ' .
                $complaint->ticket_number .
                ' berhasil dikirim ke CC Room.'
            );
    }


    /**
     * Halaman ulasan pengguna.
     */
    public function feedback($id)
    {
        $complaint = Complaint::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'status',
                'selesai'
            )
            ->findOrFail($id);

        if (
            \App\Models\Feedback::where(
                'complaint_id',
                $id
            )->exists()
        ) {
            return redirect()
                ->route('complaints.index')
                ->with(
                    'success',
                    'Anda sudah memberikan ulasan untuk tiket ini.'
                );
        }

        return view(
            'complaints.feedback',
            compact('complaint')
        );
    }


    /**
     * Menyimpan ulasan pengguna.
     */
    public function storeFeedback(
        Request $request,
        $id
    ) {
        $complaint = Complaint::where(
            'user_id',
            Auth::id()
        )->findOrFail($id);

        $validated = $request->validate([
            'rating' =>
                'required|integer|min:1|max:5',

            'comment' =>
                'nullable|string',
        ]);

        \App\Models\Feedback::create([
            'complaint_id' =>
                $complaint->id,

            'rating' =>
                $validated['rating'],

            'comment' =>
                $validated['comment'],
        ]);

        return redirect()
            ->route('complaints.index')
            ->with(
                'success',
                'Terima kasih! Ulasan Anda sangat berarti bagi layanan Trans Semarang.'
            );
    }


    /**
     * Legacy method.
     *
     * Dipertahankan untuk kompatibilitas route lama.
     */
    public function store_resolve(
        Request $request,
        $id
    ) {
        /*
        |--------------------------------------------------------------------------
        | Arahkan ke method utama
        |--------------------------------------------------------------------------
        |
        | Method lama masih menggunakan nama field yang sama,
        | sehingga kita cukup meneruskan proses ke storeResolution().
        |
        */

        return $this->storeResolution(
            $request,
            $id
        );
    }
}
