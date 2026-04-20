<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            // Tambah kolom laci_id setelah kolom status
            $table->foreignId('laci_id')
                  ->nullable()
                  ->after('status')
                  ->constrained('laci')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->dropForeign(['laci_id']);
            $table->dropColumn('laci_id');
        });
    }
};