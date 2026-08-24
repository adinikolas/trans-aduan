<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintHistory;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Menampilkan halaman sesuai role user.
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

            $complaints = Complaint::with([
                    'user',
                    'category',
                    'division'
                ])
                ->where('division_id', $user->division_id)
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

            $complaints = Complaint::with([
                    'user',
                    'category',
                    'division'
                ])
                ->where('division_id', $user->division_id)
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


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MANAGER KEUANGAN
    |--------------------------------------------------------------------------
    */
    public function dashboardManagerKeuangan()
    {
        $user = Auth::user();

        if ($user->role !== 'manager_keuangan') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $divisionId = $user->division_id;

        /*
        |--------------------------------------------------------------------------
        | Statistik utama
        |--------------------------------------------------------------------------
        */
        $baseQuery = Complaint::where(
            'division_id',
            $divisionId
        );

        $totalAduan = (clone $baseQuery)->count();

        $selesai = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $diproses = (clone $baseQuery)
            ->where('status', 'diproses')
            ->count();

        $menungguValidasi = (clone $baseQuery)
            ->where(
                'status',
                'menunggu_validasi_cc'
            )
            ->count();

        $belumDitindaklanjuti = (clone $baseQuery)
            ->whereIn('status', [
                'menunggu',
                'diproses',
                'menunggu_validasi_cc'
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Rekap berdasarkan kategori
        |--------------------------------------------------------------------------
        */
        $categoryStats = Category::where(
            'division_id',
            $divisionId
        )
            ->withCount([

                'complaints as total_complaints' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    );
                },

                'complaints as diproses_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'diproses'
                    );
                },

                'complaints as validasi_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu_validasi_cc'
                    );
                },

                'complaints as selesai_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'selesai'
                    );
                },

            ])
            ->orderByDesc('total_complaints')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Rekap 6 bulan terakhir
        |--------------------------------------------------------------------------
        */
        $startDate = now()
            ->startOfMonth()
            ->subMonths(5);

        $monthlyData = Complaint::where(
            'division_id',
            $divisionId
        )
            ->where(
                'created_at',
                '>=',
                $startDate
            )
            ->selectRaw(
                "DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total"
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $monthlyStats = collect();

        for ($i = 5; $i >= 0; $i--) {

            $date = now()
                ->startOfMonth()
                ->subMonths($i);

            $key = $date->format('Y-m');

            $data = $monthlyData->firstWhere(
                'bulan',
                $key
            );

            $monthlyStats->push([
                'bulan' => $key,
                'label' => $date->translatedFormat('F Y'),
                'total' => $data
                    ? $data->total
                    : 0,
            ]);
        }

        return view(
            'manager.keuangan.dashboard',
            compact(
                'totalAduan',
                'selesai',
                'diproses',
                'menungguValidasi',
                'belumDitindaklanjuti',
                'categoryStats',
                'monthlyStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */
    public function dashboardManagerOperasional()
    {
        $user = Auth::user();

        if ($user->role !== 'manager_operasional') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $divisionId = $user->division_id;

        /*
        |--------------------------------------------------------------------------
        | Statistik utama
        |--------------------------------------------------------------------------
        */
        $baseQuery = Complaint::where(
            'division_id',
            $divisionId
        );

        $totalAduan = (clone $baseQuery)->count();

        $selesai = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $diproses = (clone $baseQuery)
            ->where('status', 'diproses')
            ->count();

        $menungguValidasi = (clone $baseQuery)
            ->where(
                'status',
                'menunggu_validasi_cc'
            )
            ->count();

        $belumDitindaklanjuti = (clone $baseQuery)
            ->whereIn('status', [
                'menunggu',
                'diproses',
                'menunggu_validasi_cc'
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Rekap berdasarkan kategori
        |--------------------------------------------------------------------------
        */
        $categoryStats = Category::where(
            'division_id',
            $divisionId
        )
            ->withCount([

                'complaints as total_complaints' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    );
                },

                'complaints as diproses_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'diproses'
                    );
                },

                'complaints as validasi_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu_validasi_cc'
                    );
                },

                'complaints as selesai_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'selesai'
                    );
                },

            ])
            ->orderByDesc('total_complaints')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Rekap 6 bulan terakhir
        |--------------------------------------------------------------------------
        */
        $startDate = now()
            ->startOfMonth()
            ->subMonths(5);

        $monthlyData = Complaint::where(
            'division_id',
            $divisionId
        )
            ->where(
                'created_at',
                '>=',
                $startDate
            )
            ->selectRaw(
                "DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total"
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $monthlyStats = collect();

        for ($i = 5; $i >= 0; $i--) {

            $date = now()
                ->startOfMonth()
                ->subMonths($i);

            $key = $date->format('Y-m');

            $data = $monthlyData->firstWhere(
                'bulan',
                $key
            );

            $monthlyStats->push([
                'bulan' => $key,
                'label' => $date->translatedFormat('F Y'),
                'total' => $data
                    ? $data->total
                    : 0,
            ]);
        }

        return view(
            'manager.operasional.dashboard',
            compact(
                'totalAduan',
                'selesai',
                'diproses',
                'menungguValidasi',
                'belumDitindaklanjuti',
                'categoryStats',
                'monthlyStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR ADUAN MANAGER KEUANGAN
    |--------------------------------------------------------------------------
    */
    public function aduanManagerKeuangan(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'manager_keuangan') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $complaints = Complaint::with([
                'user',
                'category',
                'division'
            ])
            ->where(
                'division_id',
                $user->division_id
            )
            ->whereIn(
                'status',
                [
                    'diproses',
                    'menunggu_validasi_cc'
                ]
            )
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'title',
                        'like',
                        '%' . $search . '%'
                    );
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where(
                    'status',
                    $status
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'manager.keuangan.aduan',
            compact('complaints')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR ADUAN MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */
    public function aduanManagerOperasional(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'manager_operasional') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $complaints = Complaint::with([
                'user',
                'category',
                'division'
            ])
            ->where(
                'division_id',
                $user->division_id
            )
            ->whereIn(
                'status',
                [
                    'diproses',
                    'menunggu_validasi_cc'
                ]
            )
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'title',
                        'like',
                        '%' . $search . '%'
                    );
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where(
                    'status',
                    $status
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'manager.operasional.aduan',
            compact('complaints')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | JENIS ADUAN MANAGER KEUANGAN
    |--------------------------------------------------------------------------
    */
    public function jenisAduanManagerKeuangan()
    {
        $user = Auth::user();

        if ($user->role !== 'manager_keuangan') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $divisionId = $user->division_id;

        $categoryStats = Category::where(
            'division_id',
            $divisionId
        )
            ->withCount([

                'complaints as total_complaints' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    );
                },

                'complaints as menunggu_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu'
                    );
                },

                'complaints as diproses_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'diproses'
                    );
                },

                'complaints as validasi_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu_validasi_cc'
                    );
                },

                'complaints as selesai_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'selesai'
                    );
                },

                'complaints as ditolak_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'ditolak'
                    );
                },

            ])
            ->orderByDesc('total_complaints')
            ->get();

        return view(
            'manager.keuangan.jenis_aduan',
            compact('categoryStats')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | JENIS ADUAN MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */
    public function jenisAduanManagerOperasional()
    {
        $user = Auth::user();

        if ($user->role !== 'manager_operasional') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $divisionId = $user->division_id;

        $categoryStats = Category::where(
            'division_id',
            $divisionId
        )
            ->withCount([

                'complaints as total_complaints' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    );
                },

                'complaints as menunggu_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu'
                    );
                },

                'complaints as diproses_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'diproses'
                    );
                },

                'complaints as validasi_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'menunggu_validasi_cc'
                    );
                },

                'complaints as selesai_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'selesai'
                    );
                },

                'complaints as ditolak_count' => function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )
                    ->where(
                        'status',
                        'ditolak'
                    );
                },

            ])
            ->orderByDesc('total_complaints')
            ->get();

        return view(
            'manager.operasional.jenis_aduan',
            compact('categoryStats')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM BUAT ADUAN
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | SIMPAN ADUAN BARU
    |--------------------------------------------------------------------------
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
            'title' =>
                'required|string|max:255',

            'category_id' =>
                'required|exists:categories,id',

            'incident_time' =>
                'required|date',

            'bus_number' =>
                'nullable|string|max:50',

            'description' =>
                'required|string',

            'evidence' =>
                'nullable|image|mimes:jpeg,png,jpg|max:2048',

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
            'ticket_number' =>
                $ticketNumber,

            'user_id' =>
                Auth::id(),

            'category_id' =>
                $validatedData['category_id'],

            'title' =>
                $validatedData['title'],

            'description' =>
                $validatedData['description'],

            'incident_time' =>
                $validatedData['incident_time'],

            'bus_number' =>
                $validatedData['bus_number'] ?? null,

            'evidence_path' =>
                $evidencePath,

            'status' =>
                'menunggu',

            'division_id' =>
                null,
        ]);

        return redirect()
            ->route('complaints.index')
            ->with(
                'success',
                'Laporan aduan berhasil dikirim dengan Nomor Tiket: ' .
                $ticketNumber
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL ADUAN
    |--------------------------------------------------------------------------
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
        | Pengguna umum hanya boleh melihat aduannya sendiri
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'pengguna') {

            if ($complaint->user_id !== $user->id) {
                abort(
                    403,
                    'Anda tidak memiliki hak akses untuk melihat laporan ini.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Manager hanya boleh melihat aduan divisinya
        |--------------------------------------------------------------------------
        */
        if (in_array(
            $user->role,
            [
                'manager_keuangan',
                'manager_operasional'
            ],
            true
        )) {

            if (
                $complaint->division_id !==
                $user->division_id
            ) {
                abort(
                    403,
                    'Anda tidak memiliki hak akses ke laporan divisi lain.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Role yang diperbolehkan
        |--------------------------------------------------------------------------
        */
        $allowedRoles = [
            'cc_room',
            'manager_keuangan',
            'manager_operasional',
            'pengguna',
        ];

        if (!in_array(
            $user->role,
            $allowedRoles,
            true
        )) {
            abort(
                403,
                'Anda tidak memiliki akses ke laporan ini.'
            );
        }

        $divisions = \App\Models\Division::all();

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
    | UPDATE STATUS OLEH CC ROOM
    |--------------------------------------------------------------------------
    |
    | Division ditentukan otomatis berdasarkan kategori.
    |
    */
    public function update(
        Request $request,
        $id
    ) {
        if (Auth::user()->role !== 'cc_room') {
            abort(
                403,
                'Hanya CC Room yang dapat memperbarui status laporan.'
            );
        }

        $complaint = Complaint::with(
            'category.division'
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

        if (
            $validatedData['status'] ===
            'diproses'
        ) {

            $divisionId =
                $complaint
                    ->category
                    ->division_id;

            if (!$divisionId) {
                return back()->withErrors([
                    'status' =>
                        'Kategori laporan belum memiliki divisi penanganan.'
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update complaint
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
        if (
            $validatedData['status'] ===
            'diproses'
        ) {

            $divisionName =
                $complaint
                    ->category
                    ->division
                    ->name;

            $historyNote =
                'Laporan tervalidasi oleh CC Room. ' .
                'Laporan diteruskan secara otomatis ke Divisi ' .
                $divisionName .
                '.';

        } elseif (
            $validatedData['status'] ===
            'selesai'
        ) {

            $historyNote =
                'Bukti penyelesaian divalidasi oleh CC Room. ' .
                'Tiket dinyatakan selesai dan ditutup.';

        } elseif (
            $validatedData['status'] ===
            'ditolak'
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


    /*
    |--------------------------------------------------------------------------
    | FORM TINDAK LANJUT MANAGER
    |--------------------------------------------------------------------------
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
        | Security:
        | Manager hanya boleh menangani aduan divisinya sendiri.
        |--------------------------------------------------------------------------
        */
        if (
            $complaint->division_id !==
            $user->division_id
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
        if (!in_array(
            $complaint->status,
            [
                'diproses',
                'menunggu_validasi_cc'
            ],
            true
        )) {
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


    /*
    |--------------------------------------------------------------------------
    | SIMPAN TINDAK LANJUT MANAGER
    |--------------------------------------------------------------------------
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
        | Security:
        | Manager hanya boleh menangani aduan divisinya sendiri.
        |--------------------------------------------------------------------------
        */
        if (
            $complaint->division_id !==
            $user->division_id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk menindaklanjuti aduan dari divisi lain.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status harus valid untuk ditindaklanjuti
        |--------------------------------------------------------------------------
        */
        if (!in_array(
            $complaint->status,
            [
                'diproses',
                'menunggu_validasi_cc'
            ],
            true
        )) {
            abort(
                403,
                'Laporan ini tidak dapat ditindaklanjuti.'
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
        | Update complaint
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
                    $user->role ===
                    'manager_keuangan'
                        ? 'Manager Keuangan'
                        : 'Manager Operasional'
                ) .
                '. Menunggu validasi akhir dari CC Room.',

            'created_by' =>
                Auth::id(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect ke dashboard manager masing-masing
        |--------------------------------------------------------------------------
        */
        $route =
            $user->role ===
            'manager_keuangan'
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


    /*
    |--------------------------------------------------------------------------
    | FEEDBACK PENGGUNA
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | SIMPAN FEEDBACK
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | LEGACY STORE RESOLVE
    |--------------------------------------------------------------------------
    |
    | Dipertahankan agar route lama tetap berjalan.
    |
    */
    public function store_resolve(
        Request $request,
        $id
    ) {
        return $this->storeResolution(
            $request,
            $id
        );
    }
}
