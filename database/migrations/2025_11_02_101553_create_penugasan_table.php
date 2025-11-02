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
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->string('tugas');
            $table->foreignId('kepanitiaan_id')->constrained('kepanitiaan')->onDelete('set null');
            $table->foreignId('users_id')->constrained('users')->onDelete('set null');
            $table->string('tindak_lanjut');
            $table->string('deadline');
            $table->string('status');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan');
    }
};
