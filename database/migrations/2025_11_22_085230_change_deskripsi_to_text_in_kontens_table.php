<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konten', function (Blueprint $table) {
            // Mengubah tipe kolom 'deskripsi' menjadi TEXT
            $table->text('deskripsi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konten', function (Blueprint $table) {
            // Mengembalikan tipe kolom 'deskripsi' menjadi string (VARCHAR 255)
            $table->string('deskripsi')->change();
        });
    }
};