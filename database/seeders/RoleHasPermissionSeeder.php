<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissionsAdministrator = Permission::all();
        Role::findByName('Administrador', 'sanctum')->syncPermissions($permissionsAdministrator);

        $permissionsVendor = Permission::take(25)->get();
        Role::findByName('Vendedor', 'sanctum')->syncPermissions($permissionsVendor);

        $permissionsCustomer = Permission::orderBy('id', 'desc')->take(25)->get();
        Role::findByName('Cliente', 'sanctum')->syncPermissions($permissionsCustomer);
    }
}