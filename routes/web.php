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

/*Auth::routes();*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('login.locked');
Route::post('login/locked', 'Auth\LoginController@unlock')->name('login.unlock');

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
    Route::post('fe/xml','FeFacturasController@CrearXml');
    Route::get('fe/{fe}/edit','FeFacturasController@editfactura')->name('fe.edit');
    Route::put('/fe/{fe}', 'FeFacturasController@updatefactura')->name('fe.update');
    Route::get('/fe/getDownload/{file}','FeFacturasController@getDownload');
    Route::get('/fe_configs','FeFacturasController@config');
    Route::post('/savefeConfigs','FeFacturasController@savefeConfigs');
    Route::post('/savefeConfigsNc','FeFacturasController@savefeConfigsNc');


    // Facturacion electronica Notas credito
    Route::resource('nc','FeNotasCreditoController');
    Route::post('nc/xml','FeNotasCreditoController@CrearXmlnc')->name('fe.nc.xml');
    Route::get('nc/{nc}/edit','FeNotasCreditoController@editfactura')->name('fe.nc.edit');
    Route::put('/nc/{nc}', 'FeNotasCreditoController@updatefactura')->name('fe.nc.update');

    Route::resource('ConfigFe','FeConfigController');

    // Productos CIEV --> Codificador
    Route::resource('maestros','ProdCievMaestroController');

    Route::resource('ProdCievCodTipoProducto','ProdCodTipoProductoController');

    Route::resource('ProdCievCod','ProdCodLineasController');

    Route::resource('ProdCievCodSublinea','ProdCodSublineasController');

    Route::resource('ProdCievCodCaracteristica','ProdCievCodCaracteristicaController');
    Route::get('/getsublineas','ProdCievCodCaracteristicaController@getSublineas');

    Route::resource('ProdCievCodMaterial','ProdCievCodMaterialController');
    Route::get('/getsublineas','ProdCievCodMaterialController@getSublineas');

    Route::resource('ProdCievCodMedida','ProdCievCodMedidaController');
    Route::get('/getsublineas','ProdCievCodMedidaController@getSublineas');
    Route::get('/getCaractUnidadMedidas','ProdCievCodMedidaController@getCaractUnidadMedidas');
    Route::get('/sublineasUltimoId','ProdCievCodMedidaController@ultimoId');
    Route::get('/UltimoCodId','ProdCievCodMedidaController@UltimoCodId');

    Route::resource('codificador','ProdCievCodCodigoController');
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

    Route::post('/SublineasPost','ProdCodSublineasController@SaveSublinea');
    Route::get('/SublineasIndex','ProdCodSublineasController@index');
    Route::get('/getlineasp','ProdCodSublineasController@getlineasp');
    Route::get('/getUnidadMedidas','ProdCodSublineasController@getUnidadMedidas');
    Route::get('/getCarUnidadMedidas','ProdCodSublineasController@getCarUnidadMedidas');

    Route::post('/CaracteristicasPost','ProdCievCodCaracteristicaController@store');
    Route::get('/CaracteristicasIndex','ProdCievCodCaracteristicaController@index');

    Route::post('/MaterialesPost','ProdCievCodMaterialController@store');
    Route::get('/MaterialesIndex','ProdCievCodMaterialController@index');

    Route::post('/MedidasPost','ProdCievCodMedidaController@store');
    Route::get('/MedidasIndex','ProdCievCodMedidaController@index');

    Route::post('/CodigosPost','ProdCievCodCodigoController@store');
    Route::get('/CodigosIndex','ProdCievCodCodigoController@index');

    Route::resource('clonador','CreateProductController');
    Route::get('/ProductosIndex','CreateProductController@index');
    Route::get('/SearchProducts', 'CreateProductController@SearchProducts');
    Route::get('/SearchCodes', 'CreateProductController@SearchCodes');
    Route::post('/SaveProducts','CreateProductController@SaveProducts');
    Route::get('/FacturasIndex','FeFacturasController@index');
    Route::get('/NotasCreditoIndex','FeNotasCreditoController@index');

    Route::get('/test', 'ProdCievCodCodigoController@GetCodigos');

    Route::resource('pronosticos','PronosticoController');
    Route::get('/PronosticosIndex','PronosticoController@index');
    Route::get('/PronosticosInventory','PronosticoController@Inventory');
    Route::get('/PronosticosCantCompr','PronosticoController@CantCompro');
    Route::get('/PronosticosDetailsLots','PronosticoController@DetailsLots');
    Route::get('/PronosticosPronostics','PronosticoController@Pronostics');

    Route::resource('pedidos','PedidoController');
    Route::get('/PedidosIndex','PedidoController@index');
    Route::get('/PedidosGetUsers','PedidoController@GetUsers');
    Route::get('/SearchClients','PedidoController@SearchClients');
    Route::get('/PedidosGetCondicion','PedidoController@GetCondicion');
    Route::get('/PedidosSearchProductsMax','PedidoController@SearchProductsMax');
    Route::get('/SearchArts','PedidoController@SearchArts');
    Route::post('/SavePedido','PedidoController@SavePedido');

    Route::post('/GetUniqueCod','ProdCodTipoProductoController@UniqueCod');
    Route::post('/GetUniqueCodLines','ProdCodLineasController@UniqueCod');
    Route::post('/GetUniqueCodSubLines','ProdCodSublineasController@UniqueCod');
    Route::post('/GetUniqueCodCaracteristics','ProdCievCodCaracteristicaController@UniqueCod');
    Route::post('/GetUniqueCodMaterials','ProdCievCodMaterialController@UniqueCod');
    Route::post('/GetUniqueCodMed','ProdCievCodMedidaController@UniqueCod');
    Route::post('/GetUniqueCode','ProdCievCodCodigoController@UniqueCod');
    Route::post('/GetUniqueDescription','ProdCievCodCodigoController@UniqueDescription');

    Route::get('/getALLUnidadMedidas','ProdCodSublineasController@getALLUnidadMedidas');
    Route::get('/getALLCaracteristicasUnidadMedidas','ProdCodSublineasController@getALLCaracteristicasUnidadMedidas');

    Route::post('/PedidoPromoverCartera','PedidoController@PedidoPromoverCartera');
    Route::get('/Estadopedido','PedidoController@Estadopedido');
    Route::post('/PedidoReabrir','PedidoController@PedidoReabrir');
    Route::post('/PedidoAnular','PedidoController@PedidoAnular');
    Route::get('/ImprimirPedidoPdf','PedidoController@imprimir');
    Route::get('/getStep','PedidoController@getStep');


    Route::resource('PedidoCartera','PedidoCarteraController');
    Route::get('/PedidosCarteraIndex','PedidoCarteraController@index');
    Route::post('/PedidosCarteraUpdate','PedidoCarteraController@PedidosCarteraUpdate');

    Route::resource('PedidoCostos','PedidoCostosController');
    Route::get('/PedidoCostosIndex','PedidoCostosController@index');
    Route::post('/PedidoCostosUpdate','PedidoCostosController@PedidoCostosUpdate');

    Route::resource('PedidoProduccion','PedidoProduccionController');
    Route::get('/PedidoProduccionIndex','PedidoProduccionController@index');
    Route::post('/PedidoProduccionUpdate','PedidoProduccionController@PedidoProduccionUpdate');

    Route::resource('PedidoBodega','PedidoBodegaController');
    Route::get('/PedidoBodegaIndex','PedidoBodegaController@index');
    Route::post('/PedidoBodegaUpdate','PedidoBodegaController@PedidoBodegaUpdate');

    Route::resource('Requerimientoss','RequerimientosController');
    Route::get('/RequerimientosIndex','RequerimientosController@index');
    Route::get('/SearchMarcas','RequerimientosController@SearchMarcas');
    Route::get('/RequerimientosSearchProductsMax','RequerimientosController@SearchProductsMax');
    Route::get('/Requerimientosgetlineas','RequerimientosController@getlineas');
    Route::get('/GetDescription','RequerimientosController@GetDescription');
    Route::post('RequerimientoSaveFile','RequerimientosController@RequerimientoSaveFile');
    Route::post('/NewRequerimiento','RequerimientosController@NewRequerimiento');
    Route::get('/getUnidadMedidasMed','ProdCievCodMedidaController@getUnidadMedidasMed');

    Route::get('/DatosxFactura','FeFacturasController@DatosxFactura');
    Route::get('/VerCondicionesPago','FeFacturasController@VerCondicionesPago');
    Route::post('/GuardarFacturaEdit', 'FeFacturasController@GuardarFacturaEdit');
    Route::get('/misrequerimientos','RequerimientosController@MisRequerimientos');
    Route::post('/MisRequerimientosAddComent','RequerimientosController@MisRequerimientosAddComent');


    Route::get('/GetDisenador','RequerimientosController@GetDisenador');
    Route::post('/AsignarDisenador','RequerimientosController@AsignarDisenador');
    Route::get('/RequerimientosComentariosDetalles','RequerimientosController@RequerimientosComentariosDetalles');


    Route::get('Requerimientoss/{Requerimientoss}/edit','RequerimientosController@VerRequerimiento');
    Route::post('/CambiarEstadoRequeEd','RequerimientosController@CambiarEstadoRequeEd');
    Route::get('/ObtenerDiseñadores','RequerimientosController@ObtenerDiseñadores');
    Route::post('/CambiarDiseñadorRequeEd','RequerimientosController@CambiarDiseñadorRequeEd');
    Route::post('/GuardarPropuestaReq','RequerimientosController@GuardarPropuestaReq');
    Route::get('/ListaPropuestaReq','RequerimientosController@ListaPropuestaReq');
    Route::post('/MisRequerimientosAnular','RequerimientosController@MisRequerimientosAnular');

    Route::post('/Upload2DReq','RequerimientosController@Upload2DReq');
    Route::post('/Upload3DReq','RequerimientosController@Upload3DReq');
    Route::post('/UploadPlanoReq','RequerimientosController@UploadPlanoReq');
    Route::post('/UploadfilesSupport','RequerimientosController@UploadfilesSupport');
    Route::get('/ImagesRequerimiento','RequerimientosController@ImagesRequerimiento');

    Route::resource('Artes','ArtesController');
    Route::get('/ViewArtes','ArtesController@index');
    Route::get('/DatosPropuestaPDF','RequerimientosController@DatosPropuestaPDF');
    Route::post('/DeleteFileFromPropuesta','RequerimientosController@DeleteFileFromPropuesta');
    Route::post('/FacturaElectronicaWebService','FeFacturasController@FacturasWebService');
    Route::post('/DescargarVersionGrafica','FeFacturasController@DescargarVersionGrafica');



    Route::post('/RechazarPropuesta','RequerimientosController@RechazarPropuesta');
    Route::post('/AprobarPropuesta','RequerimientosController@AprobarPropuesta');
    Route::get('/ValidarEstadoPropuestasFR','RequerimientosController@ValidarEstadoPropuestasFR');


    Route::resource('requerimientos_dashboard','RequerimientosChartsController');
    Route::get('/req_dash_requerimientosxdiseñador','RequerimientosChartsController@RequerimientosxDiseñador');
    Route::get('/req_dash_Prop_x_Estado','RequerimientosChartsController@Est_Propuestas');
    Route::get('/req_dash_All_Req','RequerimientosChartsController@All_req_est');


    Route::post('/SaveMarca','RequerimientosController@SaveMarca');
    Route::post('/UniqueMarca','RequerimientosController@UniqueMarca');
    Route::get('/ComprobarRender','RequerimientosController@ComprobarRender');
    Route::post('/EnviarRender','RequerimientosController@EnviarRender');


    Route::get('/ComprobarEstadoPropuesta','RequerimientosController@ComprobarEstadoPropuesta');
    Route::post('/FinalizaPropuesta','RequerimientosController@FinalizaPropuesta');
    Route::get('/ObtenerMediasPorCodigoBase','RequerimientosController@ObtenerMediasPorCodigoBase');
    Route::post('/CambiarMedidaPropuesta','RequerimientosController@CambiarMedidaPropuesta');


    /*    Route::get('/VerRequerimiento','RequerimientosController@VerRequerimiento');*/


});





