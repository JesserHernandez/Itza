<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();
        $this->call(PermissionSeeder::class);
    }
}
