<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
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
        $lokasi = array_keys($this->lokasiBarang);
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
            
            $barang = $this->lokasiBarang[$lokasi] ?? [];
            
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
        // Check if using temporary item
        $isTemporaryItem = $request->has('temporary_item_name') && !empty($request->temporary_item_name);

        if ($isTemporaryItem) {
            $validated = $request->validate([
                'lokasi' => 'required|string',
                'temporary_item_name' => 'required|string',
                'temporary_item_desc' => 'nullable|string',
                'detail_laporan' => 'required|string|min:10',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        } else {
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
                'deskripsi' => $request->temporary_item_desc,
                'requested_by' => Auth::id(),
                'status' => 'pending'
            ]);
        }

        $data = [
            'user_id' => Auth::id(),
            'lokasi' => $validated['lokasi'],
            'barang' => $isTemporaryItem ? $validated['temporary_item_name'] : $validated['barang'],
            'is_temporary_item' => $isTemporaryItem,
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
            $message .= ' Item baru Anda akan ditinjau oleh admin.';
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
}
