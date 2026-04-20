<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabTableAndAddLabIdToLaci extends Migration
{
    public function up()
    {
        Schema::create('lab', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lab')->unique();
            $table->string('nama_lab');
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        Schema::table('laci', function (Blueprint $table) {
            $table->foreignId('lab_id')->nullable()->constrained('lab')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('laci', function (Blueprint $table) {
            $table->dropForeign(['lab_id']);
            $table->dropColumn('lab_id');
        });
        Schema::dropIfExists('lab');
    }
}