<?php

namespace Database\Seeders;

use App\Models\Ajuste;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'Informatica',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456'),
            'estado' => true,
        ]);

        Ajuste::create([
            'nombre' => 'Gestor de Manuales',
            'descripcion' => 'Sistema gestion de manuales',
            'sucursal' => 'Central La Paz',
            'direccion' => 'Calle Uyustus 123',
            'telefonos' => '64212345',
            'email' => 'superadmin@gmail.com',
            'divisa' => 'Bs',
            'pagina_web' => '',
            'logo' => 'logos/0oCM19CTSYQt0ayiT0vwZNl6MmJqppzAwhH5r9sF.png',
            'imagen_login' => 'imagenes_login/a7qBlRVGyS0veubgIQrdVxAF3yTVK2hQ9FFTVwmo.png',
        ]);

        Role::create([
            'name' => 'Super Admin',
        ]);
        Role::create([
            'name' => 'Administrador',
        ]);
        Role::create([
            'name' => 'Usuario',
        ]);

        // Crear permisos y asignarlos a roles
        $this->call(PermissionSeeder::class);

        // Asignar rol al usuario inicial
        $user->assignRole('Super Admin');
    }
}
