<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user sudah ada
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'nama_pengguna' => 'Admin Test',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]);
        }

        if (!User::where('username', 'siswa')->exists()) {
            User::create([
                'nama_pengguna' => 'Siswa Test',
                'username' => 'siswa',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
        }

        echo "Test users created successfully!\n";
        echo "Admin - username: admin, password: password\n";
        echo "Siswa - username: siswa, password: password\n";
    }
}
