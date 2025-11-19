<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    { 
        $roles = [
            'Administrador',
            'Vendedor',
            'Cliente',
        ];
        foreach ($roles as $value) {
            Role::create(["name" => $value, "guard_name" => "sanctum"]);
        }
    }
}