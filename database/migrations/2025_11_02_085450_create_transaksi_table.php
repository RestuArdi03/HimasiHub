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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->decimal('debit', 15, 2)->nullable();
            $table->decimal('kredit', 15, 2)->nullable();
            $table->decimal('saldo', 15, 2)->nullable();
            $table->string('keterangan');
            $table->string('gambar')->nullable();
            $table->foreignId('users_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
