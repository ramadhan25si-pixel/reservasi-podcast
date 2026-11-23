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
        Schema::create('persetujuan_tata_tertib', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tata_tertib_id')->constrained('tata_tertib')->cascadeOnDelete();
            $table->foreignId('reservasi_id')->constrained('reservasi')->cascadeOnDelete();
            $table->timestamp('tanggal_persetujuan')->useCurrent();
            $table->boolean('status_persetujuan')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuan_tata_tertib');
    }
};
