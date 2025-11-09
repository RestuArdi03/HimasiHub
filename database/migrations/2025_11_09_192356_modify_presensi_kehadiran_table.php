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
            //hapus foreign key lama
            $table->dropConstrainedForeignId(['kegiatan_id']);
            $table->dropConstrainedForeignId(['anggota_id']);

            //tambah kolom hybrid
            $table->string('nama')->after('id');
            $table->unsignedBigInteger('anggota_id')->nullable()->after('nama');

            //tambah kolom polymorphic
            $table->unsignedBigInteger('presensiable_id')->after('user_id');
            $table->string('presensiable_type')->after('presensiable_id');

            //tambah kolom baru
            $table->string('keterangan_kehadiran')->default('hadir')->after('presensiable_type');
            
            //tambah foreign key
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi_kehadiran', function (Blueprint $table) {
            //hapus foreign key baru
            $table->dropForeign(['anggota_id']);

            //hapus kolom baru
            $table->dropColumn('nama');
            $table->dropColumn('anggota_id');
            $table->dropColumn('presensiable_id');
            $table->dropColumn('presensiable_type');
            $table->dropColumn('keterangan_kehadiran');

            //buat ulang kolom lama
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('restrict');
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('restrict');
        });
    }
};
