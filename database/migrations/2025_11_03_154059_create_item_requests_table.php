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
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->bigInteger('requested_by')->unsigned();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->bigInteger('reviewed_by')->unsigned()->nullable();
            $table->text('review_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_requests');
    }
};
