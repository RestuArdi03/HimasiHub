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
       // Di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('anggota_id')->nullable()->after('id');            
            $table->foreign('anggota_id')
                ->references('id')
                ->on('anggota')
                ->onDelete('set null'); 
        });

        // Di tabel anggota
        Schema::table('anggota', function (Blueprint $table) {         
            $table->foreign('users_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Hapus FK dari tabel 'users'
        Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['anggota_id']);
        $table->dropColumn('anggota_id');
        });

        // 2. Hapus FK dari tabel 'anggota'
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
        });
    }
};
