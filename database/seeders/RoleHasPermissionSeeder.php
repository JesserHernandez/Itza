<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::all();
        Role::findByName('Administrador', 'sanctum')->syncPermissions($permissions);
    }
}