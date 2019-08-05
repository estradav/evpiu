<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\PermissionGroup;

class PermissionGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalGroup = PermissionGroup::create([
            'name' => 'General',
        ]);

        Permission::where('id', 1)
                    ->update(['group_id' => $generalGroup->id]);

        $categoriesGroup = PermissionGroup::create([
            'name' => 'Categorías',
        ]);

        Permission::whereIn('id', [2,3,4,5])
                    ->update(['group_id' => $categoriesGroup->id]);

        $menusGroup = PermissionGroup::create([
            'name' => 'Menús',
        ]);

        Permission::whereIn('id', [6,7,8,9,10,11,12,13])
                    ->update(['group_id' => $menusGroup->id]);

        $permissionsGroup = PermissionGroup::create([
            'name' => 'Permisos',
        ]);

        Permission::whereIn('id', [14,15,16,17,18,19,20])
                    ->update(['group_id' => $permissionsGroup->id]);

        $postsGroup = PermissionGroup::create([
            'name' => 'Publicaciones',
        ]);

        Permission::whereIn('id', [21,22,23,24])
                    ->update(['group_id' => $postsGroup->id]);

        $rolesGroup = PermissionGroup::create([
            'name' => 'Roles',
        ]);

        Permission::whereIn('id', [25,26,27,28])
                    ->update(['group_id' => $rolesGroup->id]);

        $tagsGroup = PermissionGroup::create([
            'name' => 'Etiquetas',
        ]);

        Permission::whereIn('id', [29,30,31,32])
                    ->update(['group_id' => $tagsGroup->id]);

        $usersGroup = PermissionGroup::create([
            'name' => 'Usuarios',
        ]);

        Permission::whereIn('id', [33,34,35])
                    ->update(['group_id' => $usersGroup->id]);
    }
}
