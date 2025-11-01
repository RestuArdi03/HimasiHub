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
        if (!Schema::hasTable('roles')) {
            $this->command->warn('roles table does not exist, skipping RolesTableSeeder. Run migrations first.');
            return;
        }

        $now = Carbon::now()->toDateTimeString();

        $roles = [
            ['name' => 'tamu', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'bendahara', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'sekretaris', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'humas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pengurus lain', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('roles')->upsert($roles, ['name']);
    }
}
