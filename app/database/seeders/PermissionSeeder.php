<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Usuarios
            'usuarios.view', 'usuarios.create', 'usuarios.edit', 'usuarios.delete',
            // Cargos
            'cargos.view', 'cargos.create', 'cargos.edit', 'cargos.delete',
            // Manuales
            'manuales.view', 'manuales.create', 'manuales.edit', 'manuales.delete',
            // Ajustes
            'ajustes.view', 'ajustes.update',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $super = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $usuario = Role::firstOrCreate(['name' => 'Usuario']);

        // Super Admin: todo
        $super->syncPermissions(Permission::all());

        // Administrador: permisos de gestión básicos
        $admin->syncPermissions([
            'usuarios.view', 'usuarios.create', 'usuarios.edit',
            'cargos.view', 'cargos.create', 'cargos.edit',
            'manuales.view', 'manuales.create', 'manuales.edit',
            'ajustes.view'
        ]);

        // Usuario: solo ver manuales
        $usuario->syncPermissions(['manuales.view']);
    }
}
