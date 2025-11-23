<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konten;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Konten::factory()->count(10)->create(); // ubah variabel count untuk mengenerate artikel
    }
}
