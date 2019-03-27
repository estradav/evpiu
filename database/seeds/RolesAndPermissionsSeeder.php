<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Set default permissions
        $permissions = [
            [
                'name'          => 'dashboard.view',
                'description'   => 'Tablero'
            ],
            [
                'name'          => 'menus.list',
                'description'   => 'Mostrar menus'
            ],
            [
                'name'          => 'menus.create',
                'description'   => 'Crear menus'
            ],
            [
                'name'          => 'menus.edit',
                'description'   => 'Modificar menus'
            ],
            [
                'name'          => 'menus.destroy',
                'description'   => 'Eliminar menus'
            ],
            [
                'name'          => 'menus.items.list',
                'description'   => 'Mostrar elementos de menus'
            ],
            [
                'name'          => 'menus.items.create',
                'description'   => 'Crear elementos de menus'
            ],
            [
                'name'          => 'menus.items.edit',
                'description'   => 'Modificar elementos de menus'
            ],
            [
                'name'          => 'menus.items.destroy',
                'description'   => 'Eliminar elementos de menus'
            ],
            [
                'name'          => 'permissions.list',
                'description'   => 'Mostrar permisos'
            ],
            [
                'name'          => 'permissions.create',
                'description'   => 'Crear permisos'
            ],
            [
                'name'          => 'permissions.edit',
                'description'   => 'Modificar permisos'
            ],
            [
                'name'          => 'permissions.destroy',
                'description'   => 'Eliminar permisos'
            ],
            [
                'name'          => 'roles.list',
                'description'   => 'Mostrar roles'
            ],
            [
                'name'          => 'roles.create',
                'description'   => 'Crear roles'
            ],
            [
                'name'          => 'roles.edit',
                'description'   => 'Modificar roles'
            ],
            [
                'name'          => 'roles.destroy',
                'description'   => 'Eliminar roles'
            ],
            [
                'name'          => 'users.list',
                'description'   => 'Mostrar usuarios'
            ],
            [
                'name'          => 'users.edit',
                'description'   => 'Modificar usuarios'
            ],
            [
                'name'          => 'users.destroy',
                'description'   => 'Eliminar usuarios'
            ]
        ];

        // Set default roles
        $roles = [
            [
                'name'          => 'super-admin',
                'description'   => 'Super administrador'
            ],
            [
                'name'          => 'admin',
                'description'   => 'Administrador'
            ],
            [
                'name'          => 'user',
                'description'   => 'Usuario general'
            ]
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name'          => $permission['name'],
                'description'   => $permission['description']
            ]);
        }

        // Create roles
        foreach ($roles as $role) {
            Role::create([
                'name'          => $role['name'],
                'description'   => $role['description']
            ]);
        }

        // Assign created permissions
        Role::find(2)->givePermissionTo('dashboard.view');
        Role::find(3)->givePermissionTo('dashboard.view');
    }
}
