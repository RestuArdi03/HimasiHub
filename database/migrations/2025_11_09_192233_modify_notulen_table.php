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
        Schema::table('notulen', function (Blueprint $table) {
            //hapus kolom lama
            $table->dropConstrainedForeignId('kegiatan_id');
            $table->dropConstrainedForeignId('users_id');

            //rename kolom lama
            $table->renameColumn('judul', 'judul_rapat');
            $table->text('catatan')->nullable()->change();
            $table->renameColumn('catatan', 'catatan_tambahan');

            //tambah kolom baru
            $table->date('tanggal_rapat')->after('judul');
            $table->time('waktu_mulai')->after('tanggal_rapat');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->string('lokasi')->after('waktu_selesai');
            $table->string('tipe_rapat')->default('rutin')->after('lokasi');

            //Tambah kolom hybrid
            $table->string('pimpinan_rapat_nama')->after('tipe_rapat');
            $table->unsignedBigInteger('pimpinan_rapat_id')->nullable()->after('pimpinan_rapat_nama');
            $table->string('notulis_nama')->after('pimpinan_rapat_id');
            $table->unsignedBigInteger('notulis_id')->nullable()->after('notulis_nama');

            //foreign key
            $table->foreign('pimpinan_rapat_id')->references('id')->on('users')->OnDelete('set null');
            $table->foreign('notulis_id')->references('id')->on('users')->OnDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notulen', function (Blueprint $table) {
            //hapus kolom foreign key baru
            $table->dropForeign(['pimpinan_rapat_id']);
            $table->dropForeign(['notulis_id']);

            // hapus kolom baru
            $table->dropColumn([
                'tanggal_rapat',
                'waktu_mulai',
                'waktu_selesai',
                'lokasi',
                'tipe_rapat',
                'pimpinan_rapat_nama',
                'pimpinan_rapat_id',
                'notulis_nama',
                'notulis_id'
            ]);

            // ubah tipe kolom kembali
            $table->text('catatan_tambahan')->nullable(false)->change(); 
            
            // Kembalikan nama kolom
            $table->renameColumn('judul_rapat', 'judul');
            $table->renameColumn('catatan_tambahan', 'catatan');
            
            // buat ulang foreign key lama
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('restrict');
        });
    }
};
