<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; // [PERBAIKAN 1]: Tambahkan pemanggilan Auth

class ComplaintController extends Controller
{
    // 1. Menampilkan daftar aduan
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Output untuk Pengguna Jasa
        if ($user->role === 'pengguna') {
            $complaints = Complaint::with('category')
                            ->where('user_id', $user->id)
                            ->when($request->search, function ($query, $search) {
                                $query->where(function($q) use ($search) {
                                    $q->where('ticket_number', 'like', '%' . $search . '%')
                                      ->orWhere('title', 'like', '%' . $search . '%');
                                });
                            })
                            ->when($request->status, function ($query, $status) {
                                $query->where('status', $status);
                            })
                            ->latest()
                            ->paginate(10)->withQueryString(); // <--- UBAH DI SINI
                            
            return view('complaints.index_pengguna', compact('complaints'));
        }

        // 2. Output untuk CC Room
        if ($user->role === 'cc_room') {
            $totalAduan = Complaint::count();
            $menunggu = Complaint::where('status', 'menunggu')->count();
            $diproses = Complaint::whereIn('status', ['diproses', 'menunggu_validasi_cc'])->count();
            $selesai = Complaint::where('status', 'selesai')->count();

            $complaints = Complaint::with(['user', 'category', 'division'])
                            ->when($request->search, function ($query, $search) {
                                $query->where(function($q) use ($search) {
                                    $q->where('ticket_number', 'like', '%' . $search . '%')
                                      ->orWhere('title', 'like', '%' . $search . '%');
                                });
                            })
                            ->when($request->status, function ($query, $status) {
                                $query->where('status', $status);
                            })
                            ->latest()
                            ->paginate(10)->withQueryString(); // <--- UBAH DI SINI
                            
            return view('complaints.index_cc', compact('complaints', 'totalAduan', 'menunggu', 'diproses', 'selesai'));
        }

        // 3. Output untuk Kepala Divisi
        if ($user->role === 'kadiv') {
            $complaints = Complaint::with(['user', 'category'])
                            ->where('division_id', $user->division_id)
                            ->whereIn('status', ['diproses', 'menunggu_validasi_cc'])
                            ->when($request->search, function ($query, $search) {
                                $query->where(function($q) use ($search) {
                                    $q->where('ticket_number', 'like', '%' . $search . '%')
                                      ->orWhere('title', 'like', '%' . $search . '%');
                                });
                            })
                            ->latest()
                            ->paginate(10)->withQueryString(); // <--- UBAH DI SINI
                            
            return view('complaints.index_kadiv', compact('complaints'));
        }

        abort(403, 'Akses tidak diizinkan.');
    }

    // 2. Menampilkan formulir pembuatan aduan (Untuk Pengguna Jasa)
    public function create()
    {
        // Mengambil daftar kategori untuk ditampilkan di pilihan (dropdown) form
        $categories = Category::all();
        
        return view('complaints.create', compact('categories'));
    }

    // 3. Menyimpan data dari formulir ke database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'incident_time' => 'required|date',
            'bus_number'    => 'nullable|string|max:50',
            'description'   => 'required|string',
            // UBAH: evidence sekarang nullable (opsional)
            'evidence'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            'evidence.image' => 'File bukti harus berupa gambar.',
            'evidence.max'   => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        // UBAH: Logika penyimpanan file
        $evidencePath = null; // Default kosong
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('evidence_files', 'public');
        }

        $ticketNumber = 'TKT-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        Complaint::create([
            'ticket_number' => $ticketNumber,
            'user_id'       => \Illuminate\Support\Facades\Auth::id(), 
            'category_id'   => $validatedData['category_id'],
            'title'         => $validatedData['title'],
            'description'   => $validatedData['description'],
            'incident_time' => $validatedData['incident_time'],
            'bus_number'    => $validatedData['bus_number'] ?? null,
            'evidence_path' => $evidencePath, // Akan terisi path atau tetap null
            'status'        => 'menunggu', 
        ]);

        return redirect()->route('complaints.index')
            ->with('success', 'Laporan aduan berhasil dikirim dengan Nomor Tiket: ' . $ticketNumber);
    }

    public function show($id)
    {
        $complaint = Complaint::with(['user', 'category', 'division'])->findOrFail($id);
        $user = Auth::user();

        // PENGAMAN 1: Cegah Pengguna melihat tiket milik orang lain
        if ($user->role === 'pengguna' && $complaint->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat laporan ini.');
        }

        // PENGAMAN 2: Cegah Kadiv melihat tiket dari divisi yang berbeda
        if ($user->role === 'kadiv' && $complaint->division_id !== $user->division_id) {
            abort(403, 'Anda tidak memiliki hak akses ke laporan divisi lain.');
        }

        $divisions = \App\Models\Division::all();
        return view('complaints.show', compact('complaint', 'divisions'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Validasi input dari CC Room (Tambahkan 'selesai')
        $validatedData = $request->validate([
            'status' => 'required|in:menunggu,diproses,ditolak,selesai',
            'division_id' => 'nullable|exists:divisions,id', 
        ]);

        // Cek jika status diubah menjadi 'diproses', pastikan Divisi sudah dipilih
        if ($validatedData['status'] === 'diproses' && empty($validatedData['division_id'])) {
            return back()->withErrors(['division_id' => 'Divisi wajib dipilih jika status aduan diproses.']);
        }

        // Simpan perubahan ke tabel complaints
        $complaint->update([
            'status' => $validatedData['status'],
            'division_id' => $validatedData['division_id'],
        ]);

        // [PERBAIKAN 2]: Membuat teks riwayat yang dinamis berdasarkan status
        $historyNote = '';
        if ($validatedData['status'] === 'diproses') {
            $historyNote = 'Laporan tervalidasi oleh CC Room. Diteruskan ke divisi terkait untuk penanganan.';
        } elseif ($validatedData['status'] === 'selesai') {
            $historyNote = 'Bukti penyelesaian divalidasi oleh CC Room. Tiket dinyatakan selesai dan ditutup.';
        } elseif ($validatedData['status'] === 'ditolak') {
            $historyNote = 'Laporan ditolak oleh CC Room (Tidak valid/Spam).';
        } else {
            $historyNote = 'Status diperbarui oleh CC Room.';
        }

        // Catat ke tabel riwayat (ComplaintHistory) untuk tracking
        \App\Models\ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => $validatedData['status'],
            'note' => $historyNote,
            'created_by' => Auth::id(),
        ]);

        // Kembalikan ke halaman dashboard CC Room dengan pesan sukses
        return redirect()->route('complaints.index')
            ->with('success', 'Status laporan ' . $complaint->ticket_number . ' berhasil diperbarui.');
    }

    // Menampilkan halaman formulir tindak lanjut untuk Kadiv
    public function resolve($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Keamanan: Pastikan hanya Kadiv dari divisi yang bersangkutan yang bisa mengakses
        $user = Auth::user();
        if ($user->role !== 'kadiv' || $complaint->division_id !== $user->division_id) {
            abort(403, 'Anda tidak memiliki akses untuk menindaklanjuti laporan ini.');
        }

        return view('complaints.resolve', compact('complaint'));
    }

    // Memproses unggahan bukti perbaikan dan catatan dari Kadiv
    public function storeResolution(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'resolution_notes' => 'required|string',
            'resolution_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ], [
            'resolution_proof.image' => 'File bukti perbaikan harus berupa gambar.',
        ]);

        // Menyimpan file foto bukti perbaikan ke folder 'storage/app/public/resolution_proofs'
        $proofPath = $request->file('resolution_proof')->store('resolution_proofs', 'public');

        // Update data aduan
        $complaint->update([
            'status' => 'menunggu_validasi_cc', // Ubah status untuk dikembalikan ke CC Room
            'resolution_notes' => $validatedData['resolution_notes'],
            'resolution_proof_path' => $proofPath,
        ]);

        // Catat jejak riwayat pergerakan
        \App\Models\ComplaintHistory::create([
            'complaint_id' => $complaint->id,
            'status' => 'menunggu_validasi_cc',
            'note' => 'Perbaikan telah dilakukan oleh Divisi lapangan. Menunggu validasi akhir dari CC Room.',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('complaints.index')
            ->with('success', 'Bukti perbaikan tiket ' . $complaint->ticket_number . ' berhasil dikirim ke CC Room.');
    }

    public function feedback($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->where('status', 'selesai')->findOrFail($id);
        
        // Jika sudah pernah memberi ulasan, kembalikan
        if (\App\Models\Feedback::where('complaint_id', $id)->exists()) {
            return redirect()->route('complaints.index')->with('success', 'Anda sudah memberikan ulasan untuk tiket ini.');
        }

        return view('complaints.feedback', compact('complaint'));
    }

    public function storeFeedback(Request $request, $id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        \App\Models\Feedback::create([
            'complaint_id' => $complaint->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return redirect()->route('complaints.index')->with('success', 'Terima kasih! Ulasan Anda sangat berarti bagi layanan Trans Semarang.');
    }
}