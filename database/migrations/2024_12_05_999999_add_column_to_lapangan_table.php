<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lapangan', function (Blueprint $table) {
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('jumlah_kamar');
            $table->integer('jumlah_kamar_mandi');
            $table->integer('jumlah_lantai')->nullable();
            $table->enum('garasi', ['ada', 'tidak ada']);
        });
    }

    public function down(): void
    {
        Schema::table('lapangan', function (Blueprint $table) {
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('jumlah_kamar');
            $table->integer('jumlah_kamar_mandi');
            $table->integer('jumlah_lantai')->nullable();
            $table->enum('garasi', ['ada', 'tidak ada']);
        });
    }
}; 