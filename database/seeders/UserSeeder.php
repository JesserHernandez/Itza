<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userAdministrator = User::create([
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

        $userAdministrator->assignRole('Administrador');

        $userVendor = User::create([
            'name' => 'David Antonio',
            'surname' => 'González González',
            'identification_card' => '161-240303-1003W',
            'phone_number' => '8851 2161',
            'status' => 'Activo',
            'gender' => 'Masculino',
            'is_vendor' => true,
            'is_outstanding' => false,
            'email' => 'vendor@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
        ]);

        $userVendor->assignRole('Vendedor');

        $userCustomer = User::create([
            'name' => 'Maykeling Massiel',
            'surname' => 'González Estrada',
            'identification_card' => '161-240303-1002W',
            'phone_number' => '8918 7562',
            'status' => 'Activo',
            'gender' => 'Femenino',
            'is_vendor' => false,
            'is_outstanding' => false,
            'email' => 'customer@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
        ]);

        $userCustomer->assignRole('Cliente');
    }
}