<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = [
            "Ver Usuarios",
            "Crear Usuarios",
            "Editar Usuarios",
            "Mostrar Usuarios",
            "Eliminar Usuarios",

            "Ver Roles",
            "Crear Roles",
            "Editar Roles",
            "Mostrar Roles",
            "Eliminar Roles",

            "Ver Dashboard",
            "Crear Dashboard",
            "Editar Dashboard",
            "Mostrar Dashboard",
            "Eliminar Dashboard",

            "Ver Categoria",
            "Crear Categoria",
            "Editar Categoria",
            "Mostrar Categoria",
            "Eliminar Categoria",

            "Ver Materiales",
            "Crear Materiales",
            "Editar Materiales",
            "Mostrar Materiales",
            "Eliminar Materiales",

            "Ver Etiquetas",
            "Crear Etiquetas",
            "Editar Etiquetas",
            "Mostrar Etiquetas",
            "Eliminar Etiquetas",

            "Ver Productos",
            "Crear Productos",
            "Editar Productos",
            "Mostrar Productos",
            "Eliminar Productos",
        ];

        foreach ($permission as $value) {
            Permission::create(["name" => $value]);
        }

        User::create([
            'name' => 'Jesser Abener',
            'surname' => 'Hernandez Talavera',
            'identification_card' => '161-240303-1004W',
            'phone_number' => '5705 3615',
            'status' => 'Activo',
            'gender' => 'Masculino',
            'is_vendor' => true,
            'is_outstanding' => false,
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
        ]);
    }
}