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
        // Drop foreign key yang salah (referensi ke 'users')
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
        });

        // Tambahkan foreign key yang benar (referensi ke 'user')
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->foreign('petugas_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
        });

        // Kembalikan ke foreign key lama
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
