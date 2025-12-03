<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user admin sekali saja untuk efisiensi
        $adminUser = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'admin');
        })->first();

        if (!$adminUser) {
            $this->command->warn('Admin user not found, skipping SaldoSeeder.');
            return;
        }

        // Buat saldo untuk kas
        $saldos = [
            ['nama' => 'Kas', 'balance' => 0, 'user_id' => $adminUser->id],
            ['nama' => 'Lain-lain', 'balance' => 0, 'user_id' => $adminUser->id],
        ];

        foreach ($saldos as $saldo) {
            Saldo::create($saldo);
        }
    }
}
