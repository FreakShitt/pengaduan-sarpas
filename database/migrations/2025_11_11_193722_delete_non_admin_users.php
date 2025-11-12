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
        // Delete all pengaduan first (to avoid foreign key constraints)
        DB::table('pengaduans')->delete();
        
        // Delete all item_requests
        DB::table('item_requests')->delete();
        
        // Delete all non-admin users (keep only admin)
        DB::table('user')->where('role', '!=', 'admin')->delete();
        
        // Reset auto increment untuk user table
        DB::statement('ALTER TABLE user AUTO_INCREMENT = 2');
        DB::statement('ALTER TABLE pengaduans AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE item_requests AUTO_INCREMENT = 1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback - this is a one-way cleanup for launch simulation
    }
};
