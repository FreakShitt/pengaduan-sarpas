<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    /**
     * Dashboard Petugas - Lihat semua laporan
     */
    public function dashboard(Request $request)
    {
        $query = Pengaduan::with('user');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan lokasi
        if ($request->has('lokasi') && $request->lokasi != '') {
            $query->where('lokasi', $request->lokasi);
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('barang', 'like', '%' . $request->search . '%')
                  ->orWhere('detail_laporan', 'like', '%' . $request->search . '%');
            });
        }
        
        $pengaduans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistik
        $stats = [
            'total' => Pengaduan::count(),
            'diajukan' => Pengaduan::where('status', 'diajukan')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];
        
        return view('petugas.dashboard', compact('pengaduans', 'stats'));
    }
    
    /**
     * Detail Laporan - Petugas bisa lihat detail dan ubah status
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('petugas.detail', compact('pengaduan'));
    }
    
    /**
     * Update Status Laporan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diajukan,diproses,selesai,ditolak',
            'catatan_petugas' => 'nullable|string|max:500'
        ]);
        
        $pengaduan = Pengaduan::findOrFail($id);
        
        $pengaduan->update([
            'status' => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
            'updated_at' => now()
        ]);
        
        return redirect()->route('petugas.detail', $id)
            ->with('success', 'Status laporan berhasil diperbarui');
    }
}
