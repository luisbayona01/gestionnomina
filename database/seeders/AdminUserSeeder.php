<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);

      
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'apellidos' => 'Principal',
                'password' => Hash::make('password123'),
                'identificacion' => '123456789',
                'direccion' => 'Calle Principal 123',
                'telefono' => '1234567890',
                'ciudad_id' => null, 
                'role_id' => $adminRole->id,
            ]
        );

        // Asignar rol
        if (!$admin->hasRole('Administrador')) {
            $admin->assignRole($adminRole);
        }
    }
    
}
