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
        Schema::table('agenda', function (Blueprint $table) {
            //hapus kolom lama
            $table->dropColumn('keputusan');

            //rename dan ubah tipe kolom lama
            $table->text('pembahasan')->nullable()->change();
            $table->renameColumn('pembahasan', 'hasil_pembahasan');

            //tambah kolom baru
            $table->string('topik')->after('id');
            $table->string('status')->nullable()->after('pembahasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            //Hapus kolom baru
            $table->dropColumn('topik');
            $table->dropColumn('status');
            //Kembalikan kolom 'keputusan'
            $table->string('keputusan');

            // Ubah tipe 'hasil_pembahasan' kembali ke string
            $table->string('hasil_pembahasan')->nullable()->change();
            
            // Ganti nama kembali ke 'pembahasan'
            $table->renameColumn('hasil_pembahasan', 'pembahasan');
        });
    }
};
