<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laci', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laci')->unique();
            $table->string('nama_laci');
            $table->string('lokasi')->nullable();   // lokasi rak/lemari
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laci');
    }
};