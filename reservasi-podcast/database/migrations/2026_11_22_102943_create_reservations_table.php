<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            // pending | approved | rejected | maintenance
            $table->string('status')->default('pending');
            $table->string('purpose')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};