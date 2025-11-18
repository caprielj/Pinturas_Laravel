<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\Sucursal;
use App\Models\Usuario;

/**
 * AdminSeeder
 *
 * Crea los datos iniciales necesarios para el sistema:
 * - Roles básicos del sistema
 * - Sucursal principal
 * - Usuario administrador para pruebas
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Roles si no existen
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Gerente'],
            ['nombre' => 'Cajero'],
            ['nombre' => 'Digitador'],
        ];

        foreach ($roles as $rolData) {
            Rol::firstOrCreate(
                ['nombre' => $rolData['nombre']],
                $rolData
            );
        }

        $this->command->info('✓ Roles creados correctamente');

        // Crear Sucursal Principal si no existe
        $sucursal = Sucursal::firstOrCreate(
            ['nombre' => 'Sucursal Principal'],
            [
                'nombre' => 'Sucursal Principal',
                'direccion' => 'Ciudad de Guatemala, Guatemala',
                'telefono' => '2222-2222',
                'activa' => true,
            ]
        );

        $this->command->info('✓ Sucursal Principal creada correctamente');

        // Obtener el rol de Administrador
        $rolAdmin = Rol::where('nombre', 'Administrador')->first();

        // Crear Usuario Administrador si no existe
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@paints.com'],
            [
                'nombre' => 'Administrador',
                'dpi' => '0000000000000',
                'email' => 'admin@paints.com',
                'password_hash' => Hash::make('admin123'),
                'rol_id' => $rolAdmin->id,
                'sucursal_id' => $sucursal->id,
                'activo' => true,
            ]
        );

        $this->command->info('✓ Usuario Administrador creado correctamente');
        $this->command->info('');
        $this->command->info('Credenciales de acceso:');
        $this->command->info('Email: admin@paints.com');
        $this->command->info('Contraseña: admin123');
        $this->command->info('');
    }
}
