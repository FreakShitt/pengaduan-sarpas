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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('lokasi');
            $table->string('barang');
            $table->text('detail_laporan');
            $table->string('gambar')->nullable();
            $table->enum('status', ['pending', 'process', 'completed', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            
            // Note: Foreign key constraint removed karena incompatible types
            // Relationship handled at application level via Eloquent
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
