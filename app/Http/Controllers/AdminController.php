<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use App\Models\Barang;
use App\Models\ItemRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard(Request $request)
    {
        $totalReports = Pengaduan::count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $pendingReports = Pengaduan::where('status', 'diajukan')->count();
        $processingReports = Pengaduan::where('status', 'diproses')->count();
        $completedReports = Pengaduan::where('status', 'selesai')->count();
        $rejectedReports = Pengaduan::where('status', 'ditolak')->count();
        $totalLokasi = Lokasi::where('aktif', true)->count();
        $totalBarang = Barang::where('aktif', true)->count();

        // Get all locations for filter (not used in dashboard anymore, moved to barang)
        $lokasi = Lokasi::where('aktif', true)->orderBy('nama_lokasi')->get();
        
        // Recent reports with filters (same as petugas dashboard)
        $recentReportsQuery = Pengaduan::with(['user', 'petugas']);
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $recentReportsQuery->where(function($query) use ($search) {
                $query->where('lokasi', 'LIKE', "%{$search}%")
                      ->orWhere('barang', 'LIKE', "%{$search}%")
                      ->orWhere('detail_laporan', 'LIKE', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status != '') {
            $recentReportsQuery->where('status', $request->status);
        }
        
        // Lokasi filter (text input)
        if ($request->has('lokasi') && $request->lokasi != '') {
            $recentReportsQuery->where('lokasi', 'LIKE', '%' . $request->lokasi . '%');
        }
        
        $recentReports = $recentReportsQuery->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistics by location for barang dashboard
        $barangByLocation = Barang::select('nama_lokasi', DB::raw('count(*) as total'))
            ->where('aktif', true)
            ->groupBy('nama_lokasi')
            ->get()
            ->map(function($item) {
                // Normalize classroom names
                if (stripos($item->nama_lokasi, 'kelas') !== false || 
                    stripos($item->nama_lokasi, 'ruang kelas') !== false) {
                    $item->nama_lokasi = 'Ruang Kelas';
                }
                return $item;
            })
            ->groupBy('nama_lokasi')
            ->map(function($group) {
                return [
                    'nama_lokasi' => $group->first()->nama_lokasi,
                    'total' => $group->sum('total')
                ];
            })
            ->values();

        return view('admin.dashboard', compact(
            'totalReports',
            'totalPetugas', 
            'totalSiswa',
            'totalGuru',
            'pendingReports',
            'processingReports',
            'completedReports',
            'rejectedReports',
            'totalLokasi',
            'totalBarang',
            'recentReports',
            'lokasi',
            'barangByLocation'
        ));
    }

    // Petugas Management
    public function petugas()
    {
        $petugas = User::where('role', 'petugas')->get();

        // Get performance stats for each petugas
        foreach ($petugas as $p) {
            $p->total_handled = Pengaduan::where('catatan_petugas', '!=', null)
                ->count();
            $p->completed = Pengaduan::where('status', 'selesai')->count();
            $p->in_progress = Pengaduan::where('status', 'diproses')->count();
        }

        return view('admin.petugas.index', compact('petugas'));
    }

    public function createPetugas()
    {
        return view('admin.petugas.create');
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    // User Management (Siswa & Guru)
    public function users()
    {
        $siswa = User::where('role', 'siswa')->get();
        $guru = User::where('role', 'guru')->get();

        return view('admin.users.index', compact('siswa', 'guru'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:siswa,guru',
        ]);

        User::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Lokasi Management
    public function lokasi()
    {
        $lokasi = Lokasi::all();
        
        // Manually count barang untuk setiap lokasi
        foreach ($lokasi as $lok) {
            $lok->barang_count = Barang::where('nama_lokasi', $lok->nama_lokasi)->count();
        }
        
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function createLokasi()
    {
        return view('admin.lokasi.create');
    }

    public function storeLokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasi,nama_lokasi',
            'deskripsi' => 'nullable|string',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'deskripsi' => $request->deskripsi,
            'aktif' => true,
        ]);

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function editLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function updateLokasi(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasi,nama_lokasi,' . $id,
            'deskripsi' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->has('aktif') ? $request->aktif : $lokasi->aktif,
        ]);

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil diupdate!');
    }

    public function destroyLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        
        // Check if lokasi has barang
        $barangCount = Barang::where('nama_lokasi', $lokasi->nama_lokasi)->count();
        if ($barangCount > 0) {
            return redirect()->route('admin.lokasi.index')
                ->with('error', 'Tidak dapat menghapus lokasi yang masih memiliki barang!');
        }

        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil dihapus!');
    }

    // Barang Management
    public function barang(Request $request)
    {
        $barangQuery = Barang::query();
        
        // Get all locations for filter dropdown
        $lokasi = Lokasi::where('aktif', true)->orderBy('nama_lokasi')->get();
        
        // Filter by location if selected
        if ($request->has('lokasi') && $request->lokasi != '') {
            $selectedLokasi = $request->lokasi;
            
            // If "Ruang Kelas" is selected, include all classroom variations
            if ($selectedLokasi == 'Ruang Kelas') {
                $barangQuery->where(function($query) {
                    $query->where('nama_lokasi', 'LIKE', '%Ruang Kelas%')
                          ->orWhere('nama_lokasi', 'LIKE', '%Kelas%');
                });
            } else {
                $barangQuery->where('nama_lokasi', $selectedLokasi);
            }
        }
        
        $barang = $barangQuery->get();
        
        return view('admin.barang.index', compact('barang', 'lokasi'));
    }

    public function createBarang()
    {
        $lokasi = Lokasi::where('aktif', true)->get();
        return view('admin.barang.create', compact('lokasi'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|exists:lokasi,nama_lokasi',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Barang::create([
            'nama_lokasi' => $request->nama_lokasi,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'aktif' => true,
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $lokasi = Lokasi::where('aktif', true)->get();
        return view('admin.barang.edit', compact('barang', 'lokasi'));
    }

    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|exists:lokasi,nama_lokasi',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $barang->update([
            'nama_lokasi' => $request->nama_lokasi,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->has('aktif') ? $request->aktif : $barang->aktif,
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diupdate!');
    }

    public function destroyBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    // Laporan dengan filter
    public function laporan(Request $request)
    {
        $query = Pengaduan::with('user');

        // Filter by date range
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by lokasi
        if ($request->lokasi) {
            $query->where('lokasi', $request->lokasi);
        }

        $pengaduans = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats for filtered data
        $queryClone = Pengaduan::with('user');
        if ($request->start_date) {
            $queryClone->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $queryClone->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->lokasi) {
            $queryClone->where('lokasi', $request->lokasi);
        }

        $stats = [
            'total' => $queryClone->count(),
            'diajukan' => (clone $queryClone)->where('status', 'diajukan')->count(),
            'diproses' => (clone $queryClone)->where('status', 'diproses')->count(),
            'selesai' => (clone $queryClone)->where('status', 'selesai')->count(),
            'ditolak' => (clone $queryClone)->where('status', 'ditolak')->count(),
        ];

        $lokasiList = Lokasi::where('aktif', true)->get();
        $laporan = $pengaduans;

        return view('admin.laporan', compact('laporan', 'stats', 'lokasiList'));
    }

    // Export Laporan to PDF
    public function exportPdf(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas']);

        // Apply same filters as laporan view
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->lokasi) {
            $query->where('lokasi', $request->lokasi);
        }

        $pengaduans = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'pengaduans' => $pengaduans,
            'filters' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'lokasi' => $request->lokasi,
            ],
            'printed_at' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm'),
        ];

        return view('admin.laporan-pdf', $data);
    }

    // Export Laporan to DOC (HTML format)
    public function exportDoc(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas']);

        // Apply same filters as laporan view
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->lokasi) {
            $query->where('lokasi', $request->lokasi);
        }

        $pengaduans = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'pengaduans' => $pengaduans,
            'filters' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'lokasi' => $request->lokasi,
            ],
            'printed_at' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm'),
        ];

        $html = view('admin.laporan-doc', $data)->render();

        $filename = 'Laporan_Pengaduan_' . date('Y-m-d_His') . '.doc';

        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }

    public function itemRequests(Request $request)
    {
        $query = ItemRequest::with(['requester', 'reviewer']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $itemRequests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.item-requests.index', compact('itemRequests'));
    }

    public function approveItemRequest($id)
    {
        $itemRequest = ItemRequest::findOrFail($id);
        
        if ($itemRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Item request sudah diproses sebelumnya.');
        }

        try {
            DB::beginTransaction();

            // Check if lokasi exists, if not create it
            $lokasi = Lokasi::where('nama_lokasi', $itemRequest->nama_lokasi)->first();
            if (!$lokasi) {
                Lokasi::create([
                    'nama_lokasi' => $itemRequest->nama_lokasi,
                    'deskripsi' => 'Lokasi dari item request',
                    'aktif' => true,
                ]);
            }

            // Create new Barang
            Barang::create([
                'nama_lokasi' => $itemRequest->nama_lokasi,
                'nama_barang' => $itemRequest->nama_barang,
                'deskripsi' => $itemRequest->deskripsi,
                'aktif' => true,
            ]);

            // Update item request status
            $itemRequest->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'review_note' => 'Item telah disetujui dan ditambahkan ke daftar barang.',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Item request berhasil disetujui dan ditambahkan ke daftar barang.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectItemRequest(Request $request, $id)
    {
        $request->validate([
            'review_note' => 'required|string|max:500',
        ]);

        $itemRequest = ItemRequest::findOrFail($id);
        
        if ($itemRequest->status != 'pending') {
            return redirect()->back()->with('error', 'Item request sudah diproses sebelumnya.');
        }

        $itemRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'review_note' => $request->review_note,
        ]);

        return redirect()->back()->with('success', 'Item request berhasil ditolak.');
    }
}
