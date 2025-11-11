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
        Schema::table('transaksi', function (Blueprint $table) {
            // 1. Mengubah nama kolom 'saldo' menjadi 'saldo_akhir' untuk kejelasan
            $table->renameColumn('saldo', 'saldo_akhir');

            // 2. Menambahkan kolom foreign key untuk relasi ke tabel 'saldo'
            $table->foreignId('saldo_id')
                  ->after('users_id') // Menempatkan kolom setelah users_id
                  ->constrained('saldo')
                  ->onDelete('cascade'); // Jika saldo dihapus, transaksinya juga ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['saldo_id']);
            $table->dropColumn('saldo_id');
            $table->renameColumn('saldo_akhir', 'saldo');
        });
    }
};
