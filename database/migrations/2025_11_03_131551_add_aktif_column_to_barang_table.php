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
        Schema::table('barang', function (Blueprint $table) {
            if (!Schema::hasColumn('barang', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama_barang');
            }
            if (!Schema::hasColumn('barang', 'aktif')) {
                $table->boolean('aktif')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('aktif');
        });
    }
};
