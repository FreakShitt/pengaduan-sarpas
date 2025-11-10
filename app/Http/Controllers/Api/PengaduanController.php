<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use App\Models\Barang;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Get homepage data (statistics)
     */
    public function homepage(Request $request)
    {
        $userId = $request->user()->id;

        $stats = [
            'total_pengaduan' => Pengaduan::where('user_id', $userId)->count(),
            'diajukan' => Pengaduan::where('user_id', $userId)->where('status', 'diajukan')->count(),
            'diproses' => Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        // Get latest 5 pengaduan
        $latest = Pengaduan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($pengaduan) {
                return [
                    'id' => $pengaduan->id,
                    'lokasi' => $pengaduan->lokasi,
                    'barang' => $pengaduan->barang,
                    'detail_laporan' => $pengaduan->detail_laporan,
                    'status' => $pengaduan->status,
                    'tanggal' => $pengaduan->created_at->format('d M Y H:i'),
                    'gambar_url' => $pengaduan->gambar ? url('uploads/' . $pengaduan->gambar) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'latest_pengaduan' => $latest,
            ]
        ], 200);
    }

    /**
     * Get list lokasi for dropdown
     */
    public function getLokasi()
    {
        $lokasi = Lokasi::where('aktif', true)
            ->orderBy('nama_lokasi')
            ->get(['id', 'nama_lokasi']);

        return response()->json([
            'success' => true,
            'data' => $lokasi
        ], 200);
    }

    /**
     * Get list barang by lokasi for dropdown
     */
    public function getBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lokasi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $barang = Barang::where('nama_lokasi', $request->nama_lokasi)
            ->where('aktif', true)
            ->orderBy('nama_barang')
            ->get(['id', 'nama_barang', 'deskripsi']);

        return response()->json([
            'success' => true,
            'data' => $barang
        ], 200);
    }

    /**
     * Create new pengaduan
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'lokasi' => 'required|string',
            'barang' => 'required|string',
            'detail_laporan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'is_temporary_item' => 'nullable|boolean',
        ], [
            'lokasi.required' => 'Lokasi wajib dipilih',
            'barang.required' => 'Barang wajib dipilih',
            'detail_laporan.required' => 'Detail laporan wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'user_id' => $request->user()->id,
                'lokasi' => $request->lokasi,
                'barang' => $request->barang,
                'detail_laporan' => $request->detail_laporan,
                'status' => 'diajukan',
            ];

            // Handle temporary item
            if ($request->boolean('is_temporary_item')) {
                $data['is_temporary_item'] = true;
                
                // Create item request
                ItemRequest::create([
                    'nama_lokasi' => $request->lokasi,
                    'nama_barang' => $request->barang,
                    'deskripsi' => $request->detail_laporan,
                    'requested_by' => $request->user()->id,
                    'status' => 'diajukan',
                ]);
            }

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $data['gambar'] = $filename;
            }

            $pengaduan = Pengaduan::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dibuat',
                'data' => [
                    'id' => $pengaduan->id,
                    'status' => $pengaduan->status,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pengaduan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's pengaduan history
     */
    public function history(Request $request)
    {
        $userId = $request->user()->id;

        // Filter by status if provided
        $query = Pengaduan::where('user_id', $userId);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $pengaduan = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'lokasi' => $item->lokasi,
                    'barang' => $item->barang,
                    'detail_laporan' => $item->detail_laporan,
                    'status' => $item->status,
                    'is_temporary_item' => $item->is_temporary_item ?? false,
                    'catatan_admin' => $item->catatan_admin,
                    'catatan_petugas' => $item->catatan_petugas,
                    'tanggal' => $item->created_at->format('d M Y H:i'),
                    'gambar_url' => $item->gambar ? url('uploads/' . $item->gambar) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $pengaduan
        ], 200);
    }

    /**
     * Get detail pengaduan
     */
    public function show(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('user_id', $request->user()->id)
            ->find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pengaduan->id,
                'lokasi' => $pengaduan->lokasi,
                'barang' => $pengaduan->barang,
                'detail_laporan' => $pengaduan->detail_laporan,
                'status' => $pengaduan->status,
                'is_temporary_item' => $pengaduan->is_temporary_item ?? false,
                'catatan_admin' => $pengaduan->catatan_admin,
                'catatan_petugas' => $pengaduan->catatan_petugas,
                'tanggal' => $pengaduan->created_at->format('d M Y H:i'),
                'gambar_url' => $pengaduan->gambar ? url('uploads/' . $pengaduan->gambar) : null,
            ]
        ], 200);
    }
}
