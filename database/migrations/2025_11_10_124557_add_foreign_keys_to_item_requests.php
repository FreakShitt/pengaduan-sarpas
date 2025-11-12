<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            // Tambah foreign key untuk requested_by
            $table->foreign('requested_by')
                  ->references('id')
                  ->on('user')
                  ->onDelete('cascade');  // Hapus request jika user dihapus
            
            // Tambah foreign key untuk reviewed_by (nullable)
            $table->foreign('reviewed_by')
                  ->references('id')
                  ->on('user')
                  ->onDelete('set null');  // Set null jika admin dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            // Hapus foreign keys
            $table->dropForeign(['requested_by']);
            $table->dropForeign(['reviewed_by']);
        });
    }
};
