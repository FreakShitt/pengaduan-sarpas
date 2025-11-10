<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register new user (Siswa only)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama_pengguna.required' => 'Nama pengguna wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat user baru dengan role siswa
            $user = User::create([
                'nama_pengguna' => $request->nama_pengguna,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'siswa', // Default role untuk mobile app
            ]);

            // Buat token untuk user
            $token = $user->createToken('mobile-app')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'nama_pengguna' => $user->nama_pengguna,
                        'username' => $user->username,
                        'role' => $user->role,
                    ],
                    'token' => $token,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        // Khusus untuk mobile app, hanya siswa dan guru yang bisa login
        if (!in_array($user->role, ['siswa', 'guru'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke aplikasi mobile',
            ], 403);
        }

        // Hapus token lama
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'nama_pengguna' => $user->nama_pengguna,
                    'username' => $user->username,
                    'role' => $user->role,
                ],
                'token' => $token,
            ]
        ], 200);
    }

    /**
     * Logout user (revoke token)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // Hapus token yang sedang digunakan
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user info
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $request->user()->id,
                    'nama_pengguna' => $request->user()->nama_pengguna,
                    'username' => $request->user()->username,
                    'role' => $request->user()->role,
                ]
            ]
        ], 200);
    }
}
