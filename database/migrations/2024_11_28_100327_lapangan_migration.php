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
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('rumah');
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('jumlah_kamar');
            $table->integer('jumlah_kamar_mandi');
            $table->integer('jumlah_lantai');
            $table->enum('garasi', ['ada', 'tidak ada']);
            $table->enum('type', ['rumah']);
            $table->integer('harga');
            $table->enum('status', ['tersedia', 'tidak tersedia']);
            $table->string('deskripsi');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
