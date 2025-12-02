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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('no_hp') ->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('alamat') ->nullable();
            $table->string('foto')->nullable();
            $table->string('moto_hidup')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('instagram')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
