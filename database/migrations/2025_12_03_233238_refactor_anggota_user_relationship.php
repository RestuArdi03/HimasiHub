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
        // 1. Hapus kolom 'nama' dari tabel 'anggota'
        Schema::table('anggota', function (Blueprint $table) {
            if (Schema::hasColumn('anggota', 'nama')) {
                $table->dropColumn('nama');
            }
        });

        // 2. Tambahkan 'anggota_id' dan hapus 'foto' dari tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom anggota_id jika belum ada
            if (!Schema::hasColumn('users', 'anggota_id')) {
                $table->unsignedBigInteger('anggota_id')->nullable()->unique()->after('id');
                $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('set null');
            }

            // Hapus kolom foto jika ada
            if (Schema::hasColumn('users', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Tambahkan kembali kolom 'nama' ke tabel 'anggota'
        Schema::table('anggota', function (Blueprint $table) {
            if (!Schema::hasColumn('anggota', 'nama')) {
                $table->string('nama')->after('id');
            }
        });

        // 2. Hapus 'anggota_id' dan tambahkan kembali 'foto' ke tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'anggota_id')) {
                $table->dropForeign(['anggota_id']);
                $table->dropColumn('anggota_id');
            }
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('email');
            }
        });
    }
};
