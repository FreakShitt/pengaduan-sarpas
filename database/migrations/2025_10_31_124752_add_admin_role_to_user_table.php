<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum role untuk menambahkan 'admin'
        DB::statement("ALTER TABLE `user` MODIFY `role` ENUM('guru', 'siswa', 'petugas', 'admin') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum sebelumnya
        DB::statement("ALTER TABLE `user` MODIFY `role` ENUM('guru', 'siswa', 'petugas') NOT NULL");
    }
};
