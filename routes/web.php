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
    Route::get('/fe/getDownload/{file}','FeFacturasController@getDownload');

    // Facturacion electronica Notas credito
    Route::resource('nc','FeNotasCreditoController');
    Route::post('nc/xml','FeNotasCreditoController@DetalleFactura')->name('fe.nc.xml');
    Route::get('nc/{nc}/edit','FeNotasCreditoController@editfactura')->name('fe.nc.edit');
    Route::put('/nc/{nc}', 'FeNotasCreditoController@updatefactura')->name('fe.nc.update');

    Route::resource('ConfigFe','FeConfigController');

    // Productos CIEV --> Codificador
    Route::resource('ProdCievMaestro','ProdCievMaestroController');

    Route::resource('ProdCievCodTipoProducto','ProdCodTipoProductoController');

    Route::resource('ProdCievCod','ProdCodLineasController');

    Route::resource('ProdCievCodSublinea','ProdCodSublineasController');

    Route::resource('ProdCievCodCaracteristica','ProdCievCodCaracteristicaController');
    Route::get('/getsublineas','ProdCievCodCaracteristicaController@getSublineas');

    Route::resource('ProdCievCodMaterial','ProdCievCodMaterialController');
    Route::get('/getsublineas','ProdCievCodMaterialController@getSublineas');

    Route::resource('ProdCievCodMedida','ProdCievCodMedidaController');
    Route::get('/getsublineas','ProdCievCodMedidaController@getSublineas');


    Route::resource('ProdCievCodCodigo','ProdCievCodCodigoController');
    Route::get('/getlineas','ProdCievCodCodigoController@getlineas');
    Route::get('/getsublineas','ProdCievCodCodigoController@getsublineas');
    Route::get('/getcaracteristica','ProdCievCodCodigoController@getcaracteristica');
    Route::get('/getmaterial','ProdCievCodCodigoController@getmaterial');
    Route::get('/getmedida','ProdCievCodCodigoController@getmedida');


    Route::get('/ctp','ProdCievCodCodigoController@ctp');
    Route::get('/lns','ProdCievCodCodigoController@lns');
    Route::get('/sln','ProdCievCodCodigoController@sln');
    Route::get('/mat','ProdCievCodCodigoController@mat');
    Route::get('/car','ProdCievCodCodigoController@car');
    Route::get('/med','ProdCievCodCodigoController@med');


    Route::get('/get-user-chart-data','ChartDataController@getMonthlyUserData');
    Route::get('/get-invoice-chart-data','ChartDataController@getMonthlyInvoiceData');
    Route::get('/get-invoice-chart-data-value','ChartDataController@getMonthlyInvoiceDataValue');
    Route::get('/get-invoice-age-data-value','ChartDataController@getAgeInvoiceData');
    Route::get('/get-invoice-day-data-value','ChartDataController@getDayInvoiceData');



    Route::post('/TiposProductoPost','ProdCodTipoProductoController@store');
    Route::get('/TiposProductoIndex','ProdCodTipoProductoController@index');

    Route::post('/LineasPost','ProdCodLineasController@store');
    Route::get('/LineasIndex','ProdCodLineasController@index');

    Route::post('/SublineasPost','ProdCodSublineasController@store');
    Route::get('/SublineasIndex','ProdCodSublineasController@index');
    Route::get('/getlineasp','ProdCodSublineasController@getlineasp');

    Route::post('/CaracteristicasPost','ProdCievCodCaracteristicaController@store');
    Route::get('/CaracteristicasIndex','ProdCievCodCaracteristicaController@index');

    Route::post('/MaterialesPost','ProdCievCodMaterialController@store');
    Route::get('/MaterialesIndex','ProdCievCodMaterialController@index');

    Route::post('/MedidasPost','ProdCievCodMedidaController@store');
    Route::get('/MedidasIndex','ProdCievCodMedidaController@index');

    Route::post('/CodigosPost','ProdCievCodCodigoController@store');
    Route::get('/CodigosIndex','ProdCievCodCodigoController@index');


    Route::resource('ProductCreation','CreateProductController');
    Route::get('/ProductosIndex','CreateProductController@index');
    Route::get('/SearchProducts', 'CreateProductController@SearchProducts');
    Route::get('/SearchCodes', 'CreateProductController@SearchCodes');
    Route::post('/SaveProducts','CreateProductController@SaveProducts');



    Route::get('/test', 'CreateProductController@test');
});





