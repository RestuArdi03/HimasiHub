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

        // Create user
        User::create([
            'nama' => 'Restu Ardi Putranto',
            'email' => '19232150@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('restu123'),
            'role_id' => Role::where('nama_role', 'admin')->first()->id
        ]);
        
        User::create([
            'nama' => 'Marcus Dewantoro',
            'email' => '19240021@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('marcus123'),
            'role_id' => Role::where('nama_role', 'admin')->first()->id
        ]);
        
        User::create([
            'nama' => 'Chritina Yuli Anggita',
            'email' => '19230947@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('chritina123'),
            'role_id' => Role::where('nama_role', 'sekretaris')->first()->id
        ]);
        
        User::create([
            'nama' => 'Zahra Salsabila Afifah',
            'email' => '19240328@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('zahra123'),
            'role_id' => Role::where('nama_role', 'sekretaris')->first()->id
        ]);
        
        User::create([
            'nama' => 'Bara Rifki Annajib',
            'email' => '19230480@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('bara123'),
            'role_id' => Role::where('nama_role', 'bendahara')->first()->id
        ]);
        
        User::create([
            'nama' => 'Rifatun Nisa',
            'email' => '19240339@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('rifatun123'),
            'role_id' => Role::where('nama_role', 'bendahara')->first()->id
        ]);
        
        User::create([
            'nama' => 'Aura Ayunda Putri',
            'email' => '19240514@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('aura123'),
            'role_id' => Role::where('nama_role', 'humas')->first()->id
        ]);
        
        User::create([
            'nama' => 'Putri Fiki Amalina',
            'email' => '19240981@bsi.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('putri123'),
            'role_id' => Role::where('nama_role', 'pengurus lain')->first()->id
        ]);

    }
}