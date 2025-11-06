<?php

namespace Database\Seeders;

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

            "Ver Inventario",
            "Crear Inventario",
            "Editar Inventario",
            "Mostrar Inventario",
            "Eliminar Inventario",

            "Ver Movimientos",
            "Crear Movimientos",
            "Editar Movimientos",
            "Mostrar Movimientos",
            "Eliminar Movimientos",
        ];

        foreach ($permission as $value) {
            Permission::create(["name" => $value, "guard_name" => "sanctum"]);
        }
    }
}