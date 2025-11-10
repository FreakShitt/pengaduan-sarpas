<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama_pengguna' => 'Teknisi Lapangan',
            'username' => 'petugas',
            'password' => \Hash::make('password'),
            'role' => 'petugas'
        ]);

        \App\Models\User::create([
            'nama_pengguna' => 'Budi Santoso',
            'username' => 'budi.teknisi',
            'password' => \Hash::make('password'),
            'role' => 'petugas'
        ]);
    }
}
