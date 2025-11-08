<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nama' => 'Admin HimasiHub',
            'email' => 'admin@himasihub.test',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role_id' => Role::where('nama_role', 'admin')->first()->id
        ]);

        // Create bendahara user
        User::create([
            'nama' => 'Bendahara HimasiHub',
            'email' => 'bendahara@himasihub.test',
            'email_verified_at' => now(),
            'password' => Hash::make('bendahara123'),
            'role_id' => Role::where('nama_role', 'bendahara')->first()->id
        ]);

        // Create sekretaris user
        User::create([
            'nama' => 'Sekretaris HimasiHub',
            'email' => 'sekretaris@himasihub.test',
            'email_verified_at' => now(),
            'password' => Hash::make('sekretaris123'),
            'role_id' => Role::where('nama_role', 'sekretaris')->first()->id
        ]);

        // Create humas user
        User::create([
            'nama' => 'Humas HimasiHub',
            'email' => 'humas@himasihub.test',
            'email_verified_at' => now(),
            'password' => Hash::make('humas123'),
            'role_id' => Role::where('nama_role', 'humas')->first()->id
        ]);

        // Create some random users with 'pengurus lain' role
        $pengurusRole = Role::where('nama_role', 'pengurus lain')->first();
        User::factory()
            ->count(3)
            ->state(function (array $attributes) use ($pengurusRole) {
                return ['role_id' => $pengurusRole->id];
            })
            ->create();

        // Create some random users with 'tamu' role
        $tamuRole = Role::where('nama_role', 'tamu')->first();
        User::factory()
            ->count(5)
            ->state(function (array $attributes) use ($tamuRole) {
                return ['role_id' => $tamuRole->id];
            })
            ->create();
    }
}