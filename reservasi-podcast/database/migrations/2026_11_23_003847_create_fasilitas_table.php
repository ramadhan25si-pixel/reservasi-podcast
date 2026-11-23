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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_id')->constrained('ruang_podcast')->cascadeOnDelete();
            $table->string('nama_fasilitas');
            $table->unsignedSmallInteger('jumlah')->default(1);
            $table->string('kondisi')->default('baik'); // baik | rusak | hilang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
