<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles table exists before seeding when running in some environments
        if (!Schema::hasTable('role')) {
            $this->command->warn('role table does not exist, skipping RolesTableSeeder. Run migrations first.');
            return;
        }

        $now = Carbon::now()->toDateTimeString();

        $roles = [
            ['nama_role' => 'tamu', 'created_at' => $now, 'updated_at' => $now],
            ['nama_role' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['nama_role' => 'sekretaris', 'created_at' => $now, 'updated_at' => $now],
            ['nama_role' => 'bendahara', 'created_at' => $now, 'updated_at' => $now],
            ['nama_role' => 'humas', 'created_at' => $now, 'updated_at' => $now],
            ['nama_role' => 'pengurus lain', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('role')->upsert($roles, ['nama_role']);
    }
}
