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
