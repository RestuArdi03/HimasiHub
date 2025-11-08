<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat saldo untuk kas
        Saldo::create([
            'nama' => 'Kas',
            'balance' => 0,
            // cari user admin
            'user_id' => User::where('role_id', Role::where('name', 'admin')->first()->id)->first()->id
        ]);

        // Buat saldo untuk lain-lain
        Saldo::create([
            'nama' => 'Lain-lain',
            'balance' => 0,
            // cari user admin
            'user_id' => User::where('role_id', Role::where('name', 'admin')->first()->id)->first()->id
        ]);
    }
}
