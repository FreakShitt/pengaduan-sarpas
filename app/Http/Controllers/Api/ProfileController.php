<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Get user profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id_user,
                'nama_pengguna' => $user->nama_pengguna,
                'username' => $user->username,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ], 200);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:user,username,' . $user->id_user . ',id_user',
            'current_password' => 'required_with:new_password|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama_pengguna.required' => 'Nama pengguna wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update nama pengguna jika ada
            if ($request->has('nama_pengguna')) {
                $user->nama_pengguna = $request->nama_pengguna;
            }

            // Update username jika ada
            if ($request->has('username')) {
                $user->username = $request->username;
            }

            // Update password jika ada
            if ($request->filled('new_password')) {
                // Cek password lama
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password saat ini tidak sesuai',
                    ], 401);
                }

                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diupdate',
                'data' => [
                    'id' => $user->id_user,
                    'nama_pengguna' => $user->nama_pengguna,
                    'username' => $user->username,
                    'role' => $user->role,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update profile gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
