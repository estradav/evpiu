<?php

// Dashboard
Breadcrumbs::for('dashboard', function($trail) {
    $trail->push('Tablero', route('home'));
});

Breadcrumbs::for('tools', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Herramientas');
});

Breadcrumbs::for('menu_builder', function($trail) {
    $trail->parent('tools');
    $trail->push('Menu Builder', route('menus.index'));
});

Breadcrumbs::for('menu_structure', function($trail, $menu) {
    $trail->parent('menu_builder');
    $trail->push("Estructura ($menu->name)", route('menus.builder', $menu));
});

Breadcrumbs::for('menu_create', function($trail) {
    $trail->parent('menu_builder');
    $trail->push("Crear menú", route('menus.create'));
});

Breadcrumbs::for('menu_edit', function($trail, $menu) {
    $trail->parent('menu_builder');
    $trail->push("Modificar menú ($menu->name)", route('menus.edit', $menu));
});
