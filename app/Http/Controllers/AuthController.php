<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
     public function showRegister()
    {
        return view('Auth.register'); // file register.blade.php
    }

    // proses register
    public function register(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username'     => 'required|string|unique:user,username',
            'password'     => 'required|string|min:6',
            'role'         => 'required'
        ]);

        // simpan user baru
        User::create([
            'nama_pengguna'     => $validated['nama_pengguna'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // redirect ke login atau dashboard
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }
    public function showLogin() {
        return view('Auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            if ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            }
            
            // Siswa dan Guru ke dashboard biasa
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput($request->only('username'));
    }

    public function showDashboard() {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Ambil data pengaduan milik user yang login
        $pengaduans = \App\Models\Pengaduan::where('user_id', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Hitung statistik
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'diajukan')->count(),
            'diproses' => $pengaduans->where('status', 'diproses')->count(),
            'selesai' => $pengaduans->where('status', 'selesai')->count(),
            'ditolak' => $pengaduans->where('status', 'ditolak')->count(),
        ];
        
        return view('user.dashboard', compact('pengaduans', 'stats'));
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
