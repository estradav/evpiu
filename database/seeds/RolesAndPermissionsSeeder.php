<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\PermissionGroup;

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
                'description'   => 'Tablero',
                'protected'     => 0
            ],
            [
                'name'          => 'categories.list',
                'description'   => 'Mostrar categorías',
                'protected'     => 0
            ],
            [
                'name'          => 'categories.create',
                'description'   => 'Crear categorías',
                'protected'     => 0
            ],
            [
                'name'          => 'categories.edit',
                'description'   => 'Modificar categorías',
                'protected'     => 0
            ],
            [
                'name'          => 'categories.destroy',
                'description'   => 'Eliminar categorías',
                'protected'     => 1
            ],
            [
                'name'          => 'menus.list',
                'description'   => 'Mostrar menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.create',
                'description'   => 'Crear menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.edit',
                'description'   => 'Modificar menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.destroy',
                'description'   => 'Eliminar menus',
                'protected'     => 1
            ],
            [
                'name'          => 'menus.items.list',
                'description'   => 'Mostrar elementos de menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.items.create',
                'description'   => 'Crear elementos de menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.items.edit',
                'description'   => 'Modificar elementos de menus',
                'protected'     => 0
            ],
            [
                'name'          => 'menus.items.destroy',
                'description'   => 'Eliminar elementos de menus',
                'protected'     => 1
            ],
            [
                'name'          => 'permissions.list',
                'description'   => 'Mostrar permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permissions.create',
                'description'   => 'Crear permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permissions.edit',
                'description'   => 'Modificar permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permissions.destroy',
                'description'   => 'Eliminar permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permission_groups.list',
                'description'   => 'Mostrar grupos de permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permission_groups.create',
                'description'   => 'Crear grupos de permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permission_groups.edit',
                'description'   => 'Modificar grupos de permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'permission_groups.destroy',
                'description'   => 'Eliminar grupos de permisos',
                'protected'     => 1
            ],
            [
                'name'          => 'posts.list',
                'description'   => 'Mostrar publicaciones',
                'protected'     => 0
            ],
            [
                'name'          => 'posts.create',
                'description'   => 'Crear publicaciones',
                'protected'     => 0
            ],
            [
                'name'          => 'posts.edit',
                'description'   => 'Modificar publicaciones',
                'protected'     => 0
            ],
            [
                'name'          => 'posts.destroy',
                'description'   => 'Eliminar publicaciones',
                'protected'     => 1
            ],
            [
                'name'          => 'roles.list',
                'description'   => 'Mostrar roles',
                'protected'     => 1
            ],
            [
                'name'          => 'roles.create',
                'description'   => 'Crear roles',
                'protected'     => 1
            ],
            [
                'name'          => 'roles.edit',
                'description'   => 'Modificar roles',
                'protected'     => 1
            ],
            [
                'name'          => 'roles.destroy',
                'description'   => 'Eliminar roles',
                'protected'     => 1
            ],
            [
                'name'          => 'tags.list',
                'description'   => 'Mostrar etiquetas',
                'protected'     => 0
            ],
            [
                'name'          => 'tags.create',
                'description'   => 'Crear etiquetas',
                'protected'     => 0
            ],
            [
                'name'          => 'tags.edit',
                'description'   => 'Modificar etiquetas',
                'protected'     => 0
            ],
            [
                'name'          => 'tags.destroy',
                'description'   => 'Eliminar etiquetas',
                'protected'     => 1
            ],
            [
                'name'          => 'users.list',
                'description'   => 'Mostrar usuarios',
                'protected'     => 0
            ],
            [
                'name'          => 'users.edit',
                'description'   => 'Modificar usuarios',
                'protected'     => 0
            ],
            [
                'name'          => 'users.destroy',
                'description'   => 'Eliminar usuarios',
                'protected'     => 1
            ]
        ];

        // Set default roles
        $roles = [
            [
                'name'          => 'super-admin',
                'description'   => 'Super administrador',
                'protected'     => 1
            ],
            [
                'name'          => 'admin',
                'description'   => 'Administrador',
                'protected'     => 1
            ],
            [
                'name'          => 'user',
                'description'   => 'Usuario general',
                'protected'     => 0
            ]
        ];

        // Creates default permission group to associate all default permissions
        PermissionGroup::create(['name' => 'Estándar']);

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name'          => $permission['name'],
                'description'   => $permission['description'],
                'protected'     => $permission['protected']
            ]);
        }

        // Create roles
        foreach ($roles as $role) {
            Role::create([
                'name'          => $role['name'],
                'description'   => $role['description'],
                'protected'     => $role['protected']
            ]);
        }

        // Assign created permissions
        Role::find(2)->givePermissionTo('dashboard.view');
        Role::find(3)->givePermissionTo('dashboard.view');
    }
}
