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
        Schema::table('presensi_kehadiran', function (Blueprint $table) {
            
            // --- LANGKAH 1: HAPUS FOREIGN KEY & KOLOM LAMA (YANG BENAR) ---
            $table->dropForeign('presensi_kehadiran_anggota_id_foreign');
            $table->dropColumn('anggota_id'); // [FIX] Perintahnya dropColumn

            $table->dropForeign('presensi_kehadiran_kegiatan_id_foreign');
            $table->dropColumn('kegiatan_id'); // [FIX] Perintahnya dropColumn

            // --- LANGKAH 2: TAMBAH KOLOM "HYBRID" (KE USERS) ---
            $table->string('peserta_nama')->after('id'); // [FIX] Namanya 'peserta_nama'
            $table->unsignedBigInteger('user_id')->nullable()->after('peserta_nama'); // [FIX] Pakai 'user_id', BUKAN 'anggota_id'
            
            // --- LANGKAH 3: TAMBAH KOLOM "POLYMORPHIC" ACARA ---
            $table->unsignedBigInteger('presensiable_id')->after('user_id'); 
            $table->string('presensiable_type')->after('presensiable_id');

            // --- LANGKAH 4: TAMBAH KOLOM KETERANGAN ---
            $table->string('keterangan_kehadiran')->default('Hadir')->after('presensiable_type');
            
            // --- LANGKAH 5: TAMBAH FOREIGN KEY BARU (KE USERS) ---
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // [FIX] Foreign key ke 'users'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi_kehadiran', function (Blueprint $table) {
            // --- LANGKAH 1: HAPUS FOREIGN KEY BARU ---
            $table->dropForeign(['user_id']); // Hapus foreign key 'user_id'

            // --- LANGKAH 2: HAPUS KOLOM BARU ---
            $table->dropColumn('peserta_nama');
            $table->dropColumn('user_id'); // Hapus kolom 'user_id'
            $table->dropColumn('presensiable_id');
            $table->dropColumn('presensiable_type');
            $table->dropColumn('keterangan_kehadiran');

            // --- LANGKAH 3: BUAT KEMBALI KOLOM LAMA ---
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('restrict');
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('restrict');
        });
    }
};