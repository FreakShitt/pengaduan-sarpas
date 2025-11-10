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
        // Ubah kolom status ke VARCHAR sementara
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
        
        // Update existing data
        DB::statement("UPDATE pengaduans SET status = 'diajukan' WHERE status = 'pending'");
        DB::statement("UPDATE pengaduans SET status = 'diproses' WHERE status = 'process'");
        DB::statement("UPDATE pengaduans SET status = 'selesai' WHERE status = 'completed'");
        DB::statement("UPDATE pengaduans SET status = 'ditolak' WHERE status = 'rejected'");
        
        // Ubah kembali ke enum dengan nilai bahasa Indonesia
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('diajukan', 'diproses', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum semula
        DB::statement("UPDATE pengaduans SET status = 'pending' WHERE status = 'diajukan'");
        DB::statement("UPDATE pengaduans SET status = 'process' WHERE status = 'diproses'");
        DB::statement("UPDATE pengaduans SET status = 'completed' WHERE status = 'selesai'");
        DB::statement("UPDATE pengaduans SET status = 'rejected' WHERE status = 'ditolak'");
        
        DB::statement("ALTER TABLE `pengaduans` MODIFY `status` ENUM('pending', 'process', 'completed', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
