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
        // Tambahkan kolom yang mungkin belum ada
        if (!Schema::hasColumn('barang', 'nama_lokasi')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->string('nama_lokasi')->after('id');
            });
        }
        if (!Schema::hasColumn('barang', 'deskripsi')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->text('deskripsi')->nullable()->after('nama_barang');
            });
        }
        if (!Schema::hasColumn('barang', 'aktif')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->boolean('aktif')->default(true);
            });
        }
        
        // Drop lokasi_id jika ada
        if (Schema::hasColumn('barang', 'lokasi_id')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->dropColumn('lokasi_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            if (!Schema::hasColumn('barang', 'lokasi_id')) {
                $table->unsignedBigInteger('lokasi_id')->after('id');
            }
            if (Schema::hasColumn('barang', 'nama_lokasi')) {
                $table->dropColumn('nama_lokasi');
            }
        });
    }
};
