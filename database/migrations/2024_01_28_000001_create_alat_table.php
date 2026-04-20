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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat')->unique();
            $table->string('nama_alat');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->integer('jumlah_total');
            $table->integer('jumlah_tersedia');
            $table->string('kondisi')->default('baik'); // baik, rusak ringan, rusak berat
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
