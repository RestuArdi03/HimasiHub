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
        Schema::table('konten', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom deskripsi
            // 'draft' untuk konten yang belum tayang, 'published' untuk yang sudah tayang
            $table->string('status')->default('draft')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konten', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
