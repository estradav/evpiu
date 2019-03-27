<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'BlogController@index')->name('blog');
Route::get('/post/{post}', 'BlogController@post')->name('post');
Route::get('/post/tag/{tag}', 'BlogController@tag')->name('tag');
Route::get('/post/category/{category}', 'BlogController@category')->name('category');

Auth::routes();

Route::middleware(['auth'])->group(function() {
    // Dashboard
    Route::get('/home', 'HomeController@index')
        ->name('home')
        ->middleware('role:user');

    // Anyone who has the role of super-admin or admin
    Route::group(['middleware' => 'role:super-admin|admin'], function () {
        Route::resource('posts', 'PostController');
        Route::resource('tags', 'TagController');
        Route::resource('categories', 'CategoryController');

        // Menus
        Route::get('menus', 'MenuController@index')->name('menus.index');
        Route::get('menus/create', 'MenuController@create')->name('menus.create');
        Route::post('menus/store', 'MenuController@store')->name('menus.store');
        Route::get('menus/{menu}/edit', 'MenuController@edit')->name('menus.edit');
        Route::put('menus/{menu}', 'MenuController@update')->name('menus.update');
        Route::delete('menus/{menu}', 'MenuController@destroy')->name('menus.destroy');

        // Menu Items
        Route::get('/menus/{menu}/builder', 'MenuItemController@builder')->name('menus.builder');
        Route::post('/menus/{menu}/order', 'MenuController@sort_item')->name('menus.order');
        Route::post('/menus/{menu}/item/', 'MenuItemController@store')->name('menus.item.add');
        Route::put('/menus/{menu}/item/', 'MenuItemController@update')->name('menus.item.update');
        Route::delete('/menus/{menu}/item/{id}', 'MenuItemController@destroy')->name('menus.item.destroy');
    });

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');
});
