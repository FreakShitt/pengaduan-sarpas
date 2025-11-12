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
        Schema::table('pengaduans', function (Blueprint $table) {
            // Ubah user_id dari integer menjadi bigInteger
            // Ini penting untuk kompatibilitas dengan user.id (bigint)
            $table->unsignedBigInteger('user_id')->change();
            
            // Sekarang bisa tambah foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user')
                  ->onDelete('cascade');  // Hapus pengaduan jika user dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['user_id']);
            
            // Kembalikan ke integer
            $table->unsignedInteger('user_id')->change();
        });
    }
};
