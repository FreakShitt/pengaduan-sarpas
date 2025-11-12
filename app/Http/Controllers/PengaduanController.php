<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Data lokasi dan barang
    private $lokasiBarang = [
        'Ruang Kelas' => [
            'AC', 'Proyektor', 'Papan Tulis', 'Kursi', 'Meja', 'Kipas Angin', 
            'Lampu', 'Pintu', 'Jendela', 'Stop Kontak'
        ],
        'Laboratorium Komputer' => [
            'Komputer', 'Monitor', 'Keyboard', 'Mouse', 'Proyektor', 'AC',
            'Meja Komputer', 'Kursi', 'Stop Kontak', 'Jaringan Internet'
        ],
        'Laboratorium IPA' => [
            'Mikroskop', 'Tabung Reaksi', 'Bunsen Burner', 'Meja Praktikum',
            'Wastafel', 'Lemari Alat', 'AC', 'Kursi Lab', 'Lampu'
        ],
        'Perpustakaan' => [
            'Rak Buku', 'Meja Baca', 'Kursi', 'AC', 'Lampu', 'Komputer',
            'Printer', 'Kipas Angin', 'Pintu', 'Jendela'
        ],
        'Toilet' => [
            'Toilet Duduk', 'Toilet Jongkok', 'Wastafel', 'Keran Air', 
            'Pintu Toilet', 'Lampu', 'Exhaust Fan', 'Kunci Pintu'
        ],
        'Koridor' => [
            'Lampu', 'Langit-langit', 'Lantai', 'Dinding', 'Pagar', 'Tangga'
        ],
        'Kantin' => [
            'Meja Makan', 'Kursi', 'Wastafel', 'Tempat Sampah', 'Lampu',
            'Kipas Angin', 'Stop Kontak'
        ],
        'Lapangan Olahraga' => [
            'Ring Basket', 'Gawang Futsal', 'Net Voli', 'Tribun', 'Lampu Sorot',
            'Pagar Pembatas', 'Garis Lapangan'
        ],
        'Ruang Guru' => [
            'AC', 'Meja', 'Kursi', 'Komputer', 'Printer', 'Lemari',
            'Papan Pengumuman', 'Lampu', 'Stop Kontak'
        ],
        'Aula' => [
            'Kursi', 'Meja', 'Sound System', 'Proyektor', 'Layar Proyektor',
            'AC', 'Lampu', 'Panggung', 'Mic'
        ]
    ];

    public function index()
    {
        $pengaduans = Pengaduan::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        // Get lokasi from database
        $lokasiFromDB = Lokasi::where('aktif', true)
            ->pluck('nama_lokasi')
            ->toArray();
        
        // Merge with hardcoded lokasi (for backward compatibility)
        $lokasiHardcoded = array_keys($this->lokasiBarang);
        $lokasi = array_unique(array_merge($lokasiFromDB, $lokasiHardcoded));
        sort($lokasi);
        
        return view('pengaduan.create', compact('lokasi'));
    }

    public function getBarangByLokasi(Request $request)
    {
        try {
            $lokasi = $request->input('lokasi');
            
            \Log::info('Get Barang Request', [
                'lokasi' => $lokasi,
                'method' => $request->method(),
                'all_input' => $request->all(),
                'headers' => $request->headers->all()
            ]);
            
            if (!$lokasi) {
                return response()->json([
                    'error' => 'Lokasi tidak ditemukan',
                    'message' => 'Parameter lokasi diperlukan'
                ], 400);
            }
            
            // Get barang from database instead of hardcoded array
            $barang = Barang::where('nama_lokasi', $lokasi)
                ->where('aktif', true)
                ->pluck('nama_barang')
                ->toArray();
            
            // Fallback to hardcoded array if no barang found in database
            if (empty($barang)) {
                $barang = $this->lokasiBarang[$lokasi] ?? [];
            }
            
            \Log::info('Get Barang Response', [
                'lokasi' => $lokasi,
                'barang_count' => count($barang),
                'barang' => $barang
            ]);
            
            return response()->json($barang, 200, [
                'Content-Type' => 'application/json',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get Barang Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Check if using temporary item (barang baru yang belum terdaftar)
        $isTemporaryItem = $request->filled('temporary_item_name');

        if ($isTemporaryItem) {
            // Validasi untuk barang baru
            $validated = $request->validate([
                'lokasi' => 'required|string',
                'temporary_item_name' => 'required|string',
                'temporary_item_desc' => 'nullable|string',
                'detail_laporan' => 'required|string|min:10',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        } else {
            // Validasi untuk barang yang sudah ada di daftar
            $validated = $request->validate([
                'lokasi' => 'required|string',
                'barang' => 'required|string',
                'detail_laporan' => 'required|string|min:10',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        }

        // Create item request if using temporary item
        if ($isTemporaryItem) {
            $itemRequest = \App\Models\ItemRequest::create([
                'nama_lokasi' => $validated['lokasi'],
                'nama_barang' => $validated['temporary_item_name'],
                'deskripsi' => $request->temporary_item_desc ?? 'Barang baru request dari pengaduan',
                'requested_by' => Auth::id(),
                'status' => 'pending'
            ]);
        }

        $data = [
            'user_id' => Auth::id(),
            'lokasi' => $validated['lokasi'],
            'barang' => $isTemporaryItem ? $validated['temporary_item_name'] : $validated['barang'],
            'is_temporary_item' => $isTemporaryItem ? 1 : 0,
            'detail_laporan' => $validated['detail_laporan'],
            'status' => 'diajukan'
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengaduan'), $filename);
            $data['gambar'] = $filename;
        }

        Pengaduan::create($data);

        $message = 'Pengaduan berhasil dikirim!';
        if ($isTemporaryItem) {
            $message .= ' Barang baru Anda akan ditinjau oleh admin.';
        }

        return redirect()->route('pengaduan.index')->with('success', $message);
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        
        // Pastikan user hanya bisa lihat pengaduan sendiri (kecuali admin/guru)
        if (Auth::id() !== $pengaduan->user_id && !in_array(Auth::user()->role, ['admin', 'guru'])) {
            abort(403);
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Pastikan user hanya bisa hapus pengaduan sendiri
        if (Auth::id() !== $pengaduan->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus pengaduan ini');
        }

        // Hapus gambar jika ada
        if ($pengaduan->gambar) {
            $imagePath = public_path('uploads/pengaduan/' . $pengaduan->gambar);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus pengaduan
        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus');
    }
}
