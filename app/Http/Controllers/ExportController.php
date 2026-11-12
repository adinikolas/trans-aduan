<?php

namespace App\Http\Controllers;

use App\Exports\ComplaintExport;
use App\Models\Complaint;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private function getComplaintQuery()
    {
        $user = Auth::user();

        $query = Complaint::with([
            'user',
            'category',
            'division',
        ]);

        if ($user->role === 'cc_room') {
            // CC Room dapat melihat semua aduan.
        } elseif (in_array($user->role, [
            'manager_keuangan',
            'manager_operasional',
        ])) {
            // Manager hanya dapat melihat aduan divisinya.
            if (!$user->division_id) {
                abort(403, 'Akun Manager belum memiliki divisi.');
            }

            $query->where('division_id', $user->division_id);
        } else {
            abort(403, 'Akses laporan tidak diizinkan.');
        }

        return $query;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'cc_room') {
            $divisions = Division::orderBy('name')->get();

            return view('reports.cc-room.index', compact('divisions'));
        }

        if ($user->role === 'manager_keuangan') {
            return view('reports.manager-keuangan.index');
        }

        if ($user->role === 'manager_operasional') {
            return view('reports.manager-operasional.index');
        }

        abort(403, 'Akses laporan tidak diizinkan.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'digits:4'],
            'status' => [
                'nullable',
                'in:menunggu,diproses,menunggu_validasi_cc,selesai,ditolak',
            ],
            'division_id' => ['nullable', 'integer', 'exists:divisions,id'],
        ]);

        $query = $this->getComplaintQuery();

        // Filter divisi hanya untuk CC Room.
        if ($user->role === 'cc_room' && $request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        // Filter berdasarkan bulan dan tahun kejadian.
        if ($request->filled('month')) {
            $query->whereMonth('incident_time', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('incident_time', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->orderBy('incident_time');

        $filename = 'Laporan_Aduan_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new ComplaintExport($query),
            $filename
        );
    }
}
