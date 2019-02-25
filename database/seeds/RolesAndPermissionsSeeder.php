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

        // create permissions
        Permission::create(['name' => 'browse dashboard']);
        Permission::create(['name' => 'search menus']);
        Permission::create(['name' => 'create menus']);
        Permission::create(['name' => 'edit menus']);
        Permission::create(['name' => 'destroy menus']);
        Permission::create(['name' => 'show menu structure']);
        Permission::create(['name' => 'create menu items']);
        Permission::create(['name' => 'edit menu items']);
        Permission::create(['name' => 'destroy menu items']);
        Permission::create(['name' => 'browse users']);
        Permission::create(['name' => 'search users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'destroy users']);
        Permission::create(['name' => 'browse roles']);
        Permission::create(['name' => 'search roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'destroy roles']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'user'])
            ->givePermissionTo('browse dashboard');

        // or may be done by chaining
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'search menus', 'create menus', 'edit menus', 'destroy menus',
                'show menu structure', 'create menu items', 'edit menu items',
                'destroy menu items'
            ]);

        $role = Role::create(['name' => 'super-admin']);
    }
}
