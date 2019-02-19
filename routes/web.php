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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Menu Routes
Route::resource('/menus', 'MenuController');
Route::get('/menus/{menu}/builder', 'MenuItemController@builder')->name('menus.builder');
Route::post('/menus/{menu}/order', 'MenuController@sort_item')->name('menus.order');
Route::post('/menus/{menu}/item/', 'MenuItemController@store')->name('menus.item.add');
Route::put('/menus/{menu}/item/', 'MenuItemController@update')->name('menus.item.update');
Route::delete('/menus/{menu}/item/{id}', 'MenuItemController@destroy')->name('menus.item.destroy');
