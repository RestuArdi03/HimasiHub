<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\SaldoSeeder;
use Database\Seeders\AnggotaSeeder;
use Database\Seeders\KegiatanSeeder;
use Database\Seeders\NotulenSeeder;
use Database\Seeders\KontenSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RolesTableSeeder::class);

        // Seed users after roles exist
        $this->call(UsersTableSeeder::class);

        // Seed saldos after users exist
        $this->call(SaldoSeeder::class);
        
        // Seed anggota after users exist
        $this->call(AnggotaSeeder::class);

        // Seed kegiatan after users exist
        $this->call(KegiatanSeeder::class);

        // Seed notulen after all dependencies exist
        $this->call(NotulenSeeder::class);

        // Seed konten
        $this->call(KontenSeeder::class);
    }
}
