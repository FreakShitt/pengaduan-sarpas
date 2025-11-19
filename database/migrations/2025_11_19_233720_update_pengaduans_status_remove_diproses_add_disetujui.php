<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menghapus status 'diproses' dan menambahkan 'disetujui' untuk admin
     */
    public function up(): void
    {
        // Ubah kolom status ke VARCHAR sementara
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` VARCHAR(50) NOT NULL DEFAULT 'diajukan'");
        
        // Update existing data: convert 'diproses' to 'disetujui'
        DB::statement("UPDATE pengaduans SET status = 'disetujui' WHERE status = 'diproses'");
        
        // Ubah kembali ke enum dengan status baru (tanpa diproses, dengan disetujui)
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('diajukan', 'disetujui', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ubah kolom status ke VARCHAR sementara
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` VARCHAR(50) NOT NULL DEFAULT 'diajukan'");
        
        // Kembalikan 'disetujui' ke 'diproses'
        DB::statement("UPDATE pengaduans SET status = 'diproses' WHERE status = 'disetujui'");
        
        // Kembalikan ke enum semula (dengan diproses, tanpa disetujui)
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('diajukan', 'diproses', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }
};
