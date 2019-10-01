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

use Illuminate\Support\Facades\Route;


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

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('permission_groups', 'PermissionGroupController');
    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController');
    Route::resource('posts', 'PostController');

    // Menus
    Route::resource('menus', 'MenuController');
    Route::post('/menus/{menu}/order', 'MenuController@sort_item')->name('menus.order');
    Route::get('/menus/{menu}/builder', 'MenuItemController@builder')->name('menus.builder');
    Route::post('/menus/{menu}/item/', 'MenuItemController@store')->name('menus.item.add');
    Route::put('/menus/{menu}/item/', 'MenuItemController@update')->name('menus.item.update');
    Route::delete('/menus/{menu}/item/{id}', 'MenuItemController@destroy')->name('menus.item.destroy');

    //Facturacion Electronica facturas
    Route::resource('fe','FeFacturasController');
    Route::post('fe/xml','FeFacturasController@CrearXml')->name('fe.xml');
    Route::get('fe/{fe}/edit','FeFacturasController@editfactura')->name('fe.edit');
    Route::put('/fe/{fe}', 'FeFacturasController@updatefactura')->name('fe.update');


    // Facturacion electronica Notas credito
    Route::resource('nc','FeNotasCreditoController');
    Route::post('nc/xml','FeNotasCreditoController@DetalleFactura')->name('fe.nc.xml');
    Route::get('nc/{nc}/edit','FeNotasCreditoController@editfactura')->name('fe.nc.edit');
    Route::put('/nc/{nc}', 'FeNotasCreditoController@updatefactura')->name('fe.nc.update');



    Route::resource('ConfigFe','FeConfigController');



    // Productos CIEV --> Codificador
    Route::resource('ProdCievMaestro','ProdCievMaestroController');



    Route::resource('ProdCievCod','ProdCievCodController');

});


