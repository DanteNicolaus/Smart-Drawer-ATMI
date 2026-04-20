<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->change();
            $table->string('nim')->nullable()->change();
            $table->string('jurusan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->nullable(false)->change();
            $table->string('nim')->nullable(false)->change();
            $table->string('jurusan')->nullable(false)->change();
        });
    }
};