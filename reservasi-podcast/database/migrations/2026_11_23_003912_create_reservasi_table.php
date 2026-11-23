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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ruang_id')->constrained('ruang_podcast')->cascadeOnDelete();
            $table->date('tanggal_reservasi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('keperluan');
            // pending | disetujui | ditolak | selesai | dibatalkan
            $table->string('status_reservasi')->default('pending');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamps();

            $table->index(['ruang_id', 'tanggal_reservasi', 'waktu_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
