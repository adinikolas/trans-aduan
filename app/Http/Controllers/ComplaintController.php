<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintHistory;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD / DAFTAR ADUAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | PENGGUNA UMUM
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'pengguna') {
            $baseQuery = Complaint::where('user_id', $user->id);

            $totalAduan = (clone $baseQuery)->count();

            $menunggu = (clone $baseQuery)
                ->where('status', 'menunggu')
                ->count();

            $diproses = (clone $baseQuery)
                ->whereIn('status', [
                    'diproses',
                    'menunggu_validasi_cc',
                ])
                ->count();

            $selesai = (clone $baseQuery)
                ->where('status', 'selesai')
                ->count();

            $ditolak = (clone $baseQuery)
                ->where('status', 'ditolak')
                ->count();

            $complaints = (clone $baseQuery)
                ->with([
                    'category',
                    'division',
                    'feedback',
                ])
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'ticket_number',
                            'like',
                            "%{$search}%"
                        )->orWhere(
                            'title',
                            'like',
                            "%{$search}%"
                        );
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
                compact(
                    'complaints',
                    'totalAduan',
                    'menunggu',
                    'diproses',
                    'selesai',
                    'ditolak'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CC ROOM
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'cc_room') {

        $totalAduan = Complaint::count();

        $menunggu = Complaint::where(
            'status',
            'menunggu'
        )->count();

        $diproses = Complaint::where(
            'status',
            'diproses'
        )->count();

        $menungguValidasi = Complaint::where(
            'status',
            'menunggu_validasi_cc'
        )->count();

        $selesai = Complaint::where(
            'status',
            'selesai'
        )->count();

        $complaints = Complaint::with([
                'user',
                'category',
                'division',
            ])
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
                    )
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
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
            'complaints.index_cc',
            compact(
                'complaints',
                'totalAduan',
                'menunggu',
                'diproses',
                'menungguValidasi',
                'selesai'
            )
        );
    }

        /*
        |--------------------------------------------------------------------------
        | MANAGER KEUANGAN
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'manager_keuangan') {
            $complaints = Complaint::with([
                'user',
                'category',
                'division',
            ])
                ->where(
                    'division_id',
                    $user->division_id
                )
                ->whereIn(
                    'status',
                    [
                        'diproses',
                        'menunggu_validasi_cc',
                    ]
                )
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'ticket_number',
                            'like',
                            "%{$search}%"
                        )->orWhere(
                            'title',
                            'like',
                            "%{$search}%"
                        );
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
        | MANAGER OPERASIONAL
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'manager_operasional') {
            $complaints = Complaint::with([
                'user',
                'category',
                'division',
            ])
                ->where(
                    'division_id',
                    $user->division_id
                )
                ->whereIn(
                    'status',
                    [
                        'diproses',
                        'menunggu_validasi_cc',
                    ]
                )
                ->when($request->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'ticket_number',
                            'like',
                            "%{$search}%"
                        )->orWhere(
                            'title',
                            'like',
                            "%{$search}%"
                        );
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
    | DASHBOARD PENGGUNA
    |--------------------------------------------------------------------------
    */

    private function indexPengguna(Request $request, $user)
    {
        $baseQuery = Complaint::where('user_id', $user->id);

        $totalAduan = (clone $baseQuery)->count();

        $menunggu = (clone $baseQuery)
            ->where('status', 'menunggu')
            ->count();

        $diproses = (clone $baseQuery)
            ->whereIn('status', [
                'diproses',
                'menunggu_validasi_cc',
            ])
            ->count();

        $selesai = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $complaints = (clone $baseQuery)
            ->with([
                'category',
                'division',
                'feedback',
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'title',
                        'like',
                        "%{$search}%"
                    );
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
    | DASHBOARD CC ROOM
    |--------------------------------------------------------------------------
    */

    private function indexCC(Request $request)
    {
        $totalAduan = Complaint::count();

        $menunggu = Complaint::where(
            'status',
            'menunggu'
        )->count();

        $diproses = Complaint::whereIn(
            'status',
            [
                'diproses',
                'menunggu_validasi_cc',
            ]
        )->count();

        $selesai = Complaint::where(
            'status',
            'selesai'
        )->count();

        $complaints = Complaint::with([
            'user',
            'category',
            'division',
        ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'title',
                        'like',
                        "%{$search}%"
                    );
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
    | DAFTAR ADUAN MANAGER
    |--------------------------------------------------------------------------
    */

    private function indexManager(
        Request $request,
        $user,
        string $manager
    ) {
        $complaints = Complaint::with([
            'user',
            'category',
            'division',
        ])
            ->where(
                'division_id',
                $user->division_id
            )
            ->whereIn(
                'status',
                [
                    'diproses',
                    'menunggu_validasi_cc',
                ]
            )
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'title',
                        'like',
                        "%{$search}%"
                    );
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            "complaints.index_manager_{$manager}",
            compact('complaints')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MANAGER KEUANGAN
    |--------------------------------------------------------------------------
    */

    public function dashboardManagerKeuangan()
    {
        return $this->managerDashboard(
            'manager_keuangan',
            'manager.keuangan.dashboard'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */

    public function dashboardManagerOperasional()
    {
        return $this->managerDashboard(
            'manager_operasional',
            'manager.operasional.dashboard'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATA DASHBOARD MANAGER
    |--------------------------------------------------------------------------
    */

    private function managerDashboard(
        string $role,
        string $view
    ) {
        $user = Auth::user();

        if ($user->role !== $role) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $divisionId = $user->division_id;

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
            ->whereIn(
                'status',
                [
                    'menunggu',
                    'diproses',
                    'menunggu_validasi_cc',
                ]
            )
            ->count();

        $categoryStats = $this->getCategoryStats(
            $divisionId,
            true
        );

        $monthlyStats = $this->getMonthlyStats(
            $divisionId
        );

        return view(
            $view,
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
    | STATISTIK KATEGORI
    |--------------------------------------------------------------------------
    */

    private function getCategoryStats(
        int $divisionId,
        bool $includeMenunggu = false
    ) {
        $counts = [
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
                )->where(
                    'status',
                    'diproses'
                );
            },

            'complaints as validasi_count' => function ($query) use ($divisionId) {
                $query->where(
                    'division_id',
                    $divisionId
                )->where(
                    'status',
                    'menunggu_validasi_cc'
                );
            },

            'complaints as selesai_count' => function ($query) use ($divisionId) {
                $query->where(
                    'division_id',
                    $divisionId
                )->where(
                    'status',
                    'selesai'
                );
            },

            'complaints as ditolak_count' => function ($query) use ($divisionId) {
                $query->where(
                    'division_id',
                    $divisionId
                )->where(
                    'status',
                    'ditolak'
                );
            },
        ];

        if ($includeMenunggu) {
            $counts['complaints as menunggu_count'] =
                function ($query) use ($divisionId) {
                    $query->where(
                        'division_id',
                        $divisionId
                    )->where(
                        'status',
                        'menunggu'
                    );
                };
        }

        return Category::where(
            'division_id',
            $divisionId
        )
            ->withCount($counts)
            ->orderByDesc('total_complaints')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIK 6 BULAN
    |--------------------------------------------------------------------------
    */

    private function getMonthlyStats(int $divisionId)
    {
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

        return collect(range(5, 0))
            ->reverse()
            ->map(function ($i) use ($monthlyData) {
                $date = now()
                    ->startOfMonth()
                    ->subMonths($i);

                $key = $date->format('Y-m');

                $data = $monthlyData->firstWhere(
                    'bulan',
                    $key
                );

                return [
                    'bulan' => $key,
                    'label' => $date->translatedFormat('F Y'),
                    'total' => $data
                        ? $data->total
                        : 0,
                ];
            });
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR ADUAN MANAGER KEUANGAN
    |--------------------------------------------------------------------------
    */

    public function aduanManagerKeuangan(Request $request)
    {
        return $this->managerComplaints(
            $request,
            'manager_keuangan',
            'manager.keuangan.aduan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR ADUAN MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */

    public function aduanManagerOperasional(Request $request)
    {
        return $this->managerComplaints(
            $request,
            'manager_operasional',
            'manager.operasional.aduan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR ADUAN MANAGER
    |--------------------------------------------------------------------------
    */

    private function managerComplaints(
        Request $request,
        string $role,
        string $view
    ) {
        $user = Auth::user();

        if ($user->role !== $role) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $complaints = Complaint::with([
            'user',
            'category',
            'division',
        ])
            ->where(
                'division_id',
                $user->division_id
            )
            ->whereIn(
                'status',
                [
                    'diproses',
                    'menunggu_validasi_cc',
                ]
            )
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'ticket_number',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'title',
                        'like',
                        "%{$search}%"
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
            $view,
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
        return $this->jenisAduanManager(
            'manager_keuangan',
            'manager.keuangan.jenis_aduan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | JENIS ADUAN MANAGER OPERASIONAL
    |--------------------------------------------------------------------------
    */

    public function jenisAduanManagerOperasional()
    {
        return $this->jenisAduanManager(
            'manager_operasional',
            'manager.operasional.jenis_aduan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATA JENIS ADUAN MANAGER
    |--------------------------------------------------------------------------
    */

    private function jenisAduanManager(
        string $role,
        string $view
    ) {
        $user = Auth::user();

        if ($user->role !== $role) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $categoryStats = $this->getCategoryStats(
            $user->division_id,
            true
        );

        return view(
            $view,
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
    | SIMPAN ADUAN
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

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'incident_time' => 'required|date',
            'bus_number' => 'nullable|string|max:50',
            'description' => 'required|string',
            'evidence' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'evidence.image' => 'File bukti harus berupa gambar.',
            'evidence.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        $evidencePath = $request->hasFile('evidence')
            ? $request->file('evidence')->store(
                'evidence_files',
                'public'
            )
            : null;

        $ticketNumber = 'TKT-' .
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
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'incident_time' => $validated['incident_time'],
            'bus_number' => $validated['bus_number'] ?? null,
            'evidence_path' => $evidencePath,
            'status' => 'menunggu',
            'division_id' => null,
        ]);

        return redirect()
            ->route('complaints.index')
            ->with(
                'success',
                "Laporan berhasil dikirim dengan Nomor Tiket: {$ticketNumber}"
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
            'division',
        ])->findOrFail($id);

        $user = Auth::user();

        if (
            $user->role === 'pengguna' &&
            $complaint->user_id !== $user->id
        ) {
            abort(
                403,
                'Anda tidak memiliki hak akses untuk melihat laporan ini.'
            );
        }

        if (
            in_array(
                $user->role,
                [
                    'manager_keuangan',
                    'manager_operasional',
                ],
                true
            ) &&
            $complaint->division_id !== $user->division_id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke laporan divisi lain.'
            );
        }

        $allowedRoles = [
            'cc_room',
            'manager_keuangan',
            'manager_operasional',
            'pengguna',
        ];

        if (!in_array($user->role, $allowedRoles, true)) {
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
    | UPDATE STATUS - CC ROOM
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'cc_room') {
            abort(403, 'Hanya CC Room yang dapat memperbarui status laporan.');
        }

        $complaint = Complaint::with('category.division')->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:diproses,ditolak,selesai',
        ]);

        $oldStatus = $complaint->status;

        /*
        |--------------------------------------------------------------------------
        | 1. VALIDASI AWAL
        |--------------------------------------------------------------------------
        */
        if ($oldStatus === 'menunggu') {

            if ($validated['status'] === 'diproses') {

                $divisionId = $complaint->category->division_id;

                if (!$divisionId) {
                    return back()->withErrors([
                        'status' =>
                            'Kategori laporan belum memiliki divisi penanganan.'
                    ]);
                }

                $complaint->update([
                    'status' => 'diproses',
                    'division_id' => $divisionId,
                ]);

                $divisionName = $complaint->category->division->name;

                $historyNote =
                    'Laporan tervalidasi oleh CC Room dan diteruskan ' .
                    'secara otomatis ke Divisi ' .
                    $divisionName .
                    '.';

                $historyStatus = 'diproses';

            } else {

                $complaint->update([
                    'status' => 'ditolak',
                ]);

                $historyNote =
                    'Laporan ditolak oleh CC Room karena tidak valid atau spam.';

                $historyStatus = 'ditolak';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. VALIDASI AKHIR
        |--------------------------------------------------------------------------
        */
        elseif ($oldStatus === 'menunggu_validasi_cc') {

            if ($validated['status'] === 'selesai') {

                $complaint->update([
                    'status' => 'selesai',
                ]);

                $historyNote =
                    'Bukti penyelesaian telah divalidasi oleh CC Room. ' .
                    'Tiket dinyatakan selesai dan ditutup.';

                $historyStatus = 'selesai';

            } elseif ($validated['status'] === 'diproses') {

                $complaint->update([
                    'status' => 'diproses',
                ]);

                $historyNote =
                    'Hasil tindak lanjut belum dapat divalidasi oleh CC Room. ' .
                    'Aduan dikembalikan kepada Manager untuk tindak lanjut kembali.';

                $historyStatus = 'diproses';

            } else {

                return back()->withErrors([
                    'status' => 'Status tidak valid untuk proses ini.'
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. STATUS TIDAK SESUAI
        |--------------------------------------------------------------------------
        */
        else {

            return back()->withErrors([
                'status' => 'Aduan tidak berada pada tahap yang dapat diproses.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. SIMPAN RIWAYAT
        |--------------------------------------------------------------------------
        */
        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $historyStatus,
            'note' => $historyNote,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('complaints.show', $complaint->id)
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

        if (!in_array(
            $user->role,
            [
                'manager_keuangan',
                'manager_operasional',
            ],
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

        $this->ensureManagerOwnsComplaint(
            $complaint,
            $user
        );

        if (!in_array(
            $complaint->status,
            [
                'diproses',
                'menunggu_validasi_cc',
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

        if (!in_array(
            $user->role,
            [
                'manager_keuangan',
                'manager_operasional',
            ],
            true
        )) {
            abort(
                403,
                'Hanya Manager yang dapat mengirim tindak lanjut.'
            );
        }

        $complaint = Complaint::findOrFail($id);

        $this->ensureManagerOwnsComplaint(
            $complaint,
            $user
        );

        if (!in_array(
            $complaint->status,
            [
                'diproses',
                'menunggu_validasi_cc',
            ],
            true
        )) {
            abort(
                403,
                'Laporan ini tidak dapat ditindaklanjuti.'
            );
        }

        $validated = $request->validate([
            'resolution_notes' => 'required|string',
            'resolution_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'resolution_proof.image' =>
                'File bukti perbaikan harus berupa gambar.',

            'resolution_proof.max' =>
                'Ukuran foto maksimal adalah 2MB.',
        ]);

        $proofPath = $request
            ->file('resolution_proof')
            ->store(
                'resolution_proofs',
                'public'
            );

        $complaint->update([
            'status' => 'menunggu_validasi_cc',
            'resolution_notes' => $validated['resolution_notes'],
            'resolution_proof_path' => $proofPath,
        ]);

        $managerName = $user->role === 'manager_keuangan'
            ? 'Manager Keuangan'
            : 'Manager Operasional';

        ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => 'menunggu_validasi_cc',
            'note' =>
                "Tindak lanjut telah dilakukan oleh {$managerName}. " .
                'Menunggu validasi akhir dari CC Room.',
            'created_by' => Auth::id(),
        ]);

        $route = $user->role === 'manager_keuangan'
            ? 'manager.keuangan'
            : 'manager.operasional';

        return redirect()
            ->route($route)
            ->with(
                'success',
                "Bukti penyelesaian tiket {$complaint->ticket_number} berhasil dikirim ke CC Room."
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ULASAN
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

        if (Feedback::where(
            'complaint_id',
            $id
        )->exists()) {
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
    | SIMPAN ULASAN
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

        if ($complaint->status !== 'selesai') {
            abort(
                403,
                'Ulasan hanya dapat diberikan untuk laporan yang telah selesai.'
            );
        }

        if (Feedback::where(
            'complaint_id',
            $complaint->id
        )->exists()) {
            return redirect()
                ->route('complaints.index')
                ->with(
                    'success',
                    'Anda sudah memberikan ulasan untuk tiket ini.'
                );
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Feedback::create([
            'complaint_id' => $complaint->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
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
    | HELPER MANAGER
    |--------------------------------------------------------------------------
    */

    private function ensureManagerOwnsComplaint(
        Complaint $complaint,
        $user
    ) {
        if ($complaint->division_id !== $user->division_id) {
            abort(
                403,
                'Anda tidak memiliki akses ke laporan divisi lain.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LEGACY ROUTE
    |--------------------------------------------------------------------------
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
