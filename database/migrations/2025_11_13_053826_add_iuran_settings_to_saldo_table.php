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
        Schema::table('saldo', function (Blueprint $table) {
            // Nominal iuran per pembayaran
            $table->decimal('iuran_nominal', 15, 2)->nullable()->default(5000.00)->after('balance');
            // Jumlah total iuran yang harus dibayar (misal: 12 kali dalam setahun)
            $table->unsignedInteger('jumlah_iuran')->nullable()->default(12)->after('iuran_nominal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saldo', function (Blueprint $table) {
            $table->dropColumn(['iuran_nominal', 'jumlah_iuran']);
        });
    }
};
