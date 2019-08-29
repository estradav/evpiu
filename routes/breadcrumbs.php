<?php

// Dashboard
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

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

// Posts
Breadcrumbs::for('posts', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Publicaciones', route('posts.index'));
});

Breadcrumbs::for('post_create', function($trail) {
    $trail->parent('posts');
    $trail->push('Crear publicación', route('posts.create'));
});

Breadcrumbs::for('post_edit', function($trail, $post) {
    $trail->parent('posts');
    $trail->push("Modificar publicación ($post->title)", route('posts.edit', $post));
});

// Categories
Breadcrumbs::for('categories', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Categorías', route('categories.index'));
});

Breadcrumbs::for('category_create', function($trail) {
    $trail->parent('categories');
    $trail->push('Crear categoría', route('categories.create'));
});

Breadcrumbs::for('category_edit', function($trail, $category) {
    $trail->parent('categories');
    $trail->push("Modificar categoría ($category->name)", route('categories.edit', $category));
});

// Tags
Breadcrumbs::for('tags', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Etiquetas', route('tags.index'));
});

Breadcrumbs::for('tag_create', function($trail) {
    $trail->parent('tags');
    $trail->push('Crear etiqueta', route('tags.create'));
});

Breadcrumbs::for('tag_edit', function($trail, $tag) {
    $trail->parent('tags');
    $trail->push("Modificar etiqueta ($tag->name)", route('tags.edit', $tag));
});
//Roles
Breadcrumbs::for('roles', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Roles', route('roles.index'));
});

Breadcrumbs::for('role_show', function($trail, $role) {
    $trail->parent('roles');
    $trail->push("Mostrar rol ($role->description)", route('roles.show', $role));
});

Breadcrumbs::for('role_create', function($trail) {
    $trail->parent('roles');
    $trail->push('Crear rol', route('roles.create'));
});

Breadcrumbs::for('role_edit', function($trail, $role) {
    $trail->parent('roles');
    $trail->push("Modificar rol ($role->description)", route('roles.edit', $role));
});
//permisos
Breadcrumbs::for('permissions', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Permisos', route('permissions.index'));
});

Breadcrumbs::for('permission_show', function($trail, $permission) {
    $trail->parent('permissions');
    $trail->push("Mostrar permiso ($permission->description)", route('permissions.show', $permission));
});

Breadcrumbs::for('permission_create', function($trail) {
    $trail->parent('permissions');
    $trail->push('Crear permiso', route('permissions.create'));
});

Breadcrumbs::for('permission_edit', function($trail, $permission) {
    $trail->parent('permissions');
    $trail->push("Modificar permiso ($permission->description)", route('permissions.edit', $permission));
});

Breadcrumbs::for('permission_groups', function($trail) {
    $trail->parent('permissions');
    $trail->push('Grupos', route('permission_groups.index'));
});

Breadcrumbs::for('permission_groups_create', function($trail) {
    $trail->parent('permission_groups');
    $trail->push('Crear grupo de permisos', route('permission_groups.create'));
});

Breadcrumbs::for('permission_groups_show', function($trail, $permissionGroup) {
    $trail->parent('permission_groups');
    $trail->push("Mostrar grupo de permisos ($permissionGroup->name)", route('permission_groups.show', $permissionGroup));
});

Breadcrumbs::for('permission_groups_edit', function($trail, $permissionGroup) {
    $trail->parent('permission_groups');
    $trail->push("Modificar grupo de permisos ($permissionGroup->name)", route('permission_groups.edit', $permissionGroup));
});

Breadcrumbs::for('users', function($trail) {
    $trail->parent('dashboard');
    $trail->push('Usuarios', route('users.index'));
});

Breadcrumbs::for('user_show', function($trail, $user) {
    $trail->parent('users');
    $trail->push("Mostrar usuario ($user->name)", route('users.show', $user));
});

Breadcrumbs::for('user_create', function($trail) {
    $trail->parent('users');
    $trail->push('Crear usuario', route('users.create'));
});

Breadcrumbs::for('user_edit', function($trail, $user) {
    $trail->parent('users');
    $trail->push("Modificar usuario ($user->name)", route('users.edit', $user));
});

// DMS
Breadcrumbs::for('dms', function($trail) {
    $trail->parent('dashboard');
    $trail->push('DMS', route('home'));
});

Breadcrumbs::for('dmsusers', function($trail) {
    $trail->parent('dms');
    $trail->push('Usuarios DMS', route('dmsusers.index'));
});

Breadcrumbs::for('dmsuser_show', function($trail, $dmsuser) {
    $trail->parent('dmsusers');
    $trail->push("Mostrar usuario ($dmsuser->usuario)", route('dmsusers.show', $dmsuser));
});

Breadcrumbs::for('dmsuser_create', function($trail) {
    $trail->parent('dmsuser');
    $trail->push('Crear Usuario de DMS', route('dmsusers.create'));
});

Breadcrumbs::for('dmsuser_edit', function($trail, $dmsuser) {
    $trail->parent('dmsuser');
    $trail->push("Modificar Usuario DMS ($dmsuser->usuario)", route('dmsusers.edit', $dmsuser));
});

//Terceros DMS

Breadcrumbs::for('terceros', function($trail) {
    $trail->parent('dms');
    $trail->push('Terceros DMS', route('dmsusers.index'));
});

// Max

Breadcrumbs::for('max', function($trail) {
    $trail->parent('dashboard');
    $trail->push('MAX', route('home'));
});

//clientes Max
Breadcrumbs::for('customers_max', function($trail) {
    $trail->parent('max');
    $trail->push('Clientes Max', route('customers.index'));
});

Breadcrumbs::for('customer_max_show', function($trail, $customer) {
    $trail->parent('max');
    $trail->push("Mostrar Cliente ($customer->name_23)", route('customers.show', $customer));
});

//Facturas Max
Breadcrumbs::for('invoices_max', function($trail) {
    $trail->parent('max');
    $trail->push('Facturas Max', route('invoices.index'));
});

Breadcrumbs::for('invoices_show', function($trail, $invoice) {
    $trail->parent('max');
    $trail->push("Mostrar Factura ($invoice->ordnum_31)", route('invoices.show', $invoice));
});

