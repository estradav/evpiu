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
                'order'      => 1,
            ])->save();
        }

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
                'order'      => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 3,
            'title'   => 'Tablero',
            'url'     => '',
            'route'   => 'home',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tachometer-alt',
                'parent_id'  => null,
                'order'      => 1,
            ])->save();
        }

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
                'order'      => 2,
            ])->save();
        }

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
                'order'      => 3,
            ])->save();
        }

        $toolsMenuItem = MenuItem::firstOrNew([
            'menu_id' => 2,
            'title'   => 'Herramientas',
            'url'     => '',
        ]);
        if (!$toolsMenuItem->exists) {
            $toolsMenuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-tools',
                'parent_id'  => null,
                'order'      => 2,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => 2,
            'title'   => 'Menu Builder',
            'url'     => '',
            'route'   => 'menus.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'fas fa-list',
                'parent_id'  => $toolsMenuItem->id,
                'order'      => 3,
            ])->save();
        }
    }
}
