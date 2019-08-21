<?php

use Illuminate\Database\Seeder;
use App\Menu;
use App\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        // Administrator

        // Blog
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'EVPIU Blog',
            'url'     => '',
            'route'   => 'blog',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-blog',
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

        // Tablero
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Tablero',
            'url'     => '',
            'route'   => 'home',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tachometer-alt',
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        // Categorías
        $categoriesMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Categorías',
            'url'     => '',
        ]);
        if (!$categoriesMenuItem->exists) {
            $categoriesMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-folder',
                'parent_id'  => null,
                'order'      => 3,
            ])->save();
        }

        // Categorías - Crear categoría
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear categoría',
            'url'     => '',
            'route'   => 'categories.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $categoriesMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Categorías - Mostrar categorías
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar categorías',
            'url'     => '',
            'route'   => 'categories.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $categoriesMenuItem->id,
                'order'      => 2,
            ])->save();
        }

        // Etiquetas
        $tagsMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Etiquetas',
            'url'     => '',
        ]);
        if (!$tagsMenuItem->exists) {
            $tagsMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tags',
                'parent_id'  => null,
                'order'      => 4,
            ])->save();
        }

        // Etiquetas - Crear etiqueta
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear etiqueta',
            'url'     => '',
            'route'   => 'tags.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $tagsMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Etiquetas - Mostrar etiquetas
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar etiquetas',
            'url'     => '',
            'route'   => 'tags.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $tagsMenuItem->id,
                'order'      => 2,
            ])->save();
        }

        // Permisos
        $permissionsMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Permisos',
            'url'     => '',
        ]);
        if (!$permissionsMenuItem->exists) {
            $permissionsMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-key',
                'parent_id'  => null,
                'order'      => 5,
            ])->save();
        }

        // Permisos - Crear permiso
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear permiso',
            'url'     => '',
            'route'   => 'permissions.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $permissionsMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Permisos - Mostrar permisos
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar permisos',
            'url'     => '',
            'route'   => 'permissions.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $permissionsMenuItem->id,
                'order'      => 2,
            ])->save();
        }

        // Permisos - Mostrar grupos de permisos
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar grupos de permisos',
            'url'     => '',
            'route'   => 'permission_groups.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $permissionsMenuItem->id,
                'order'      => 3,
            ])->save();
        }

        // Permisos - Crear grupos de permisos
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear grupos de permisos',
            'url'     => '',
            'route'   => 'permission_groups.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $permissionsMenuItem->id,
                'order'      => 4,
            ])->save();
        }

        // Publicaciones
        $postsMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Publicaciones',
            'url'     => '',
        ]);
        if (!$postsMenuItem->exists) {
            $postsMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-newspaper',
                'parent_id'  => null,
                'order'      => 6,
            ])->save();
        }

        // Publicaciones - Crear publicación
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear publicación',
            'url'     => '',
            'route'   => 'posts.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $postsMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Publicaciones - Mostrar publicaciones
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar publicaciones',
            'url'     => '',
            'route'   => 'posts.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $postsMenuItem->id,
                'order'      => 2,
            ])->save();
        }

        // Roles
        $rolesMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Roles',
            'url'     => '',
        ]);
        if (!$rolesMenuItem->exists) {
            $rolesMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-scroll',
                'parent_id'  => null,
                'order'      => 7,
            ])->save();
        }

        // Roles - Crear rol
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Crear rol',
            'url'     => '',
            'route'   => 'roles.create',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $rolesMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Roles - Mostrar roles
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar roles',
            'url'     => '',
            'route'   => 'roles.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $rolesMenuItem->id,
                'order'      => 2,
            ])->save();
        }

        // Usuarios
        $usersMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Usuarios',
            'url'     => '',
        ]);
        if (!$usersMenuItem->exists) {
            $usersMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-users',
                'parent_id'  => null,
                'order'      => 8,
            ])->save();
        }

        // Usuarios - Mostrar usuarios
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Mostrar usuarios',
            'url'     => '',
            'route'   => 'users.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'parent_id'  => $usersMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Herramientas
        $toolsMenuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Herramientas',
            'url'     => '',
        ]);
        if (!$toolsMenuItem->exists) {
            $toolsMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tools',
                'parent_id'  => null,
                'order'      => 9,
            ])->save();
        }

        // Herramientas - Menu builder
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 1,
            'title'   => 'Menu Builder',
            'url'     => '',
            'route'   => 'menus.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-list',
                'parent_id'  => $toolsMenuItem->id,
                'order'      => 1,
            ])->save();
        }

        // Administrator //

        // Usuario

        // Blog
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 2,
            'title'   => 'EVPIU Blog',
            'url'     => '',
            'route'   => 'blog',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-blog',
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

        // Tablero
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 2,
            'title'   => 'Tablero',
            'url'     => '',
            'route'   => 'home',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tachometer-alt',
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }
        // Usuario //
    }
}
