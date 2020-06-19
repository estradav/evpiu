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
use Illuminate\Http\Request;


Route::get('/', 'BlogController@index')->name('blog');
Route::get('/post/{post}', 'BlogController@post')->name('post');
Route::get('/post/tag/{tag}', 'BlogController@tag')->name('tag');
Route::get('/post/category/{category}', 'BlogController@category')->name('category');

/*Auth::routes();*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => ['caffeinated']], function () {
    Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('login.locked');
    Route::post('login/locked', 'Auth\LoginController@unlock')->name('login.unlock');

    Route::middleware(['auth'])->group(function() {
        Route::middleware(['auth.lock'])->group(function() {

            Route::prefix('home')->group(function () {

                /* accesos remotos */
                route::get('/accesos_remotos','HomeController@accesosremotos')->name('accesos_remotos.index');

            });


            Route::prefix('aplicaciones')->group(function () {

                /*Facturacion electronica*/
                Route::prefix('facturacion_electronica')->group(function () {

                    /*facturas*/
                    Route::resource('factura','FacturacionElectronica\FacturasController');
                    Route::post('/factura/generar_xml','FacturacionElectronica\FacturasController@generar_archivo_xml');


                    /*notas credito*/
                    Route::resource('nota_credito','FacturacionElectronica\NotasCreditoController');
                    Route::post('/nota_credito/generar_xml','FacturacionElectronica\NotasCreditoController@generar_archivo_xml');


                    /*configuracion*/
                    Route::resource('configuracions','FacturacionElectronica\ConfiguracionController');
                    Route::post('configuracions/facturas','FacturacionElectronica\ConfiguracionController@guardar_config_facturas');
                    Route::post('configuracions/notas_credito','FacturacionElectronica\ConfiguracionController@guardar_config_notas_credito');


                    /*web service*/
                    Route::post('/web_service/descargar_documento', 'FacturacionElectronica\WebServiceController@descarga_documento');
                    Route::post('/web_service/envio_facturas','FacturacionElectronica\WebServiceController@envio_facturas');
                    Route::post('/web_service/envio_notas_credito','FacturacionElectronica\WebServiceController@envio_notas_credito');
                    Route::get('/web_service/listado_documentos','FacturacionElectronica\WebServiceController@listado_documentos');
                    Route::get('/web_service/info_documento','FacturacionElectronica\WebServiceController@info_documento');
                    Route::get('/web_service/estado_dian','FacturacionElectronica\WebServiceController@estado_dian');


                    /*gestion*/
                    Route::resource('gestions','FacturacionElectronica\GestionController');
                });



                /* artes */
                Route::resource('arte','Artes\ArtesController');


                /* Gestion de terceros */
                Route::prefix('terceros')->group(function () {
                    Route::resource('cliente','Terceros\Clientes\ClientesController')->only('index');
                    Route::get('cliente/nuevo','Terceros\Clientes\ClientesController@nuevo');
                    Route::get('cliente/buscar_cliente','Terceros\Clientes\ClientesController@buscar_cliente');

                    Route::get('listar_ciudades','Terceros\Clientes\ClientesController@listar_ciudades');
                    Route::get('listar_departamentos','Terceros\Clientes\ClientesController@listar_departamentos');
                    Route::get('listar_plazos','Terceros\Clientes\ClientesController@listar_plazos');
                    Route::get('listar_vendedores','Terceros\Clientes\ClientesController@listar_vendedores');


                    Route::get('cliente/editar/{cliente}/show','Terceros\Clientes\ClientesController@show');

                    Route::post('cliente/guardar_cliente','Terceros\Clientes\ClientesController@guardar_cliente');



                    /*actualizacion de datos de cliente*/
                    Route::post('cliente/actualizar/actualizar_direccion1','Terceros\Clientes\ClientesController@actualizar_direccion1');
                    Route::post('cliente/actualizar/actualizar_direccion2','Terceros\Clientes\ClientesController@actualizar_direccion2');
                    Route::post('cliente/actualizar/actualizar_moneda','Terceros\Clientes\ClientesController@actualizar_moneda');
                    Route::post('cliente/actualizar/cambiar_tipo_cliente','Terceros\Clientes\ClientesController@cambiar_tipo_cliente');
                    Route::post('cliente/actualizar/actualizar_contacto','Terceros\Clientes\ClientesController@actualizar_contacto');
                    Route::post('cliente/actualizar/actualizar_telefono1','Terceros\Clientes\ClientesController@actualizar_telefono1');
                    Route::post('cliente/actualizar/actualizar_telefono2','Terceros\Clientes\ClientesController@actualizar_telefono2');
                    Route::post('cliente/actualizar/actualizar_celular','Terceros\Clientes\ClientesController@actualizar_celular');
                    Route::post('cliente/actualizar/actualizar_email_contacto','Terceros\Clientes\ClientesController@actualizar_email_contacto');
                    Route::post('cliente/actualizar/actualizar_email_facturacion_electronica','Terceros\Clientes\ClientesController@actualizar_email_facturacion_electronica');
                    Route::post('cliente/actualizar/actualizar_termino_pago','Terceros\Clientes\ClientesController@actualizar_termino_pago');
                    Route::post('cliente/actualizar/actualizar_descuento','Terceros\Clientes\ClientesController@actualizar_descuento');
                    Route::post('cliente/actualizar/actualizar_vendedor','Terceros\Clientes\ClientesController@actualizar_vendedor');
                    Route::post('cliente/actualizar/actualizar_correos_copia','Terceros\Clientes\ClientesController@actualizar_correos_copia');
                    Route::post('cliente/actualizar/actualizar_rut','Terceros\Clientes\ClientesController@actualizar_rut');
                    Route::post('cliente/actualizar/actualizar_gran_contribuyente','Terceros\Clientes\ClientesController@actualizar_gran_contribuyente');
                    Route::post('cliente/actualizar/actualizar_responsable_iva','Terceros\Clientes\ClientesController@actualizar_responsable_iva');
                    Route::post('cliente/actualizar/actualizar_responsable_facturacion_electronica','Terceros\Clientes\ClientesController@actualizar_responsable_facturacion_electronica');
                    Route::post('cliente/actualizar/actualizar_telefono_facturacion_electronica','Terceros\Clientes\ClientesController@actualizar_telefono_facturacion_electronica');
                    Route::post('cliente/actualizar/actualizar_codigo_ciudad_ext','Terceros\Clientes\ClientesController@actualizar_codigo_ciudad_ext');
                    Route::post('cliente/actualizar/actualizar_grupo_economico','Terceros\Clientes\ClientesController@actualizar_grupo_economico');


                    Route::get('cliente/obtener_log_cambios','Terceros\Clientes\ClientesController@obtener_log_cambios');

                });



                Route::get('/ProductosEnTendenciaPorMes','GestionClientesController@ProductosEnTendenciaPorMes');
                Route::get('/FacturacionElectronicaGc','GestionClientesController@FacturacionElectronica');
                //edit items from clients





            });

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



            Route::get('/DatosPropuestaPDF','RequerimientosController@DatosPropuestaPDF');
            Route::post('/DeleteFileFromPropuesta','RequerimientosController@DeleteFileFromPropuesta');


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
            Route::post('/types_products_update','ProdCodTipoProductoController@TypesProductUpdate');
            Route::get('/TiposProductoIndex','ProdCodTipoProductoController@index');

            Route::post('/LineasPost','ProdCodLineasController@store');
            Route::post('/lines_update','ProdCodLineasController@LinesUpdate');

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




            Route::get('/test', 'ProdCievCodCodigoController@GetCodigos');

            Route::resource('pronosticos','PronosticoController');
            Route::get('/PronosticosIndex','PronosticoController@index');
            Route::get('/PronosticosInventory','PronosticoController@Inventory');
            Route::get('/PronosticosCantCompr','PronosticoController@CantCompro');
            Route::get('/PronosticosDetailsLots','PronosticoController@DetailsLots');
            Route::get('/PronosticosPronostics','PronosticoController@Pronostics');
            Route::get('/Pronostico_para_cerrar','PronosticoController@Pronostico_para_cerrar');
            Route::post('/cerrar_pronosticos','PronosticoController@cerrar_pronosticos');


            Route::resource('pedidos','PedidoController');
            Route::get('/PedidosIndex','PedidoController@index');
            Route::get('/PedidosGetUsers','PedidoController@GetUsers');
            Route::get('/SearchClients','PedidoController@SearchClients');
            Route::get('/PedidosGetCondicion','PedidoController@GetCondicion');
            Route::get('/PedidosSearchProductsMax','PedidoController@SearchProductsMax');
            Route::get('/SearchArts','PedidoController@SearchArts');
            Route::post('/SavePedido','PedidoController@SavePedido');
            Route::post('/update_pedido','PedidoController@update');

            Route::get('/pedidos_nuevo','PedidoController@nuevo_pedido_index');

            Route::post('/GetUniqueCod','ProdCodTipoProductoController@UniqueCod');
            Route::post('/GetUniqueCodLines','ProdCodLineasController@UniqueCod');
            Route::post('/GetUniqueCodSubLines','ProdCodSublineasController@UniqueCod');
            Route::post('/GetUniqueCodCaracteristics','ProdCievCodCaracteristicaController@UniqueCod');
            Route::post('/GetUniqueCodMaterials','ProdCievCodMaterialController@UniqueCod');
            Route::post('/GetUniqueCodMed','ProdCievCodMedidaController@UniqueCod');
            Route::post('/UniqueDenominacion','ProdCievCodMedidaController@UniqueDenominacion');
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
            Route::post('/EnviarAprobarPropuesta','RequerimientosController@EnviarAprobarPropuesta');
            Route::get('/ObtenerUltimoArte','RequerimientosController@ObtenerUltimoArte');
            Route::get('/ObtenerArtes','RequerimientosController@ObtenerArtes');
            Route::post('/AgregarCaracteristicaPropuesta','RequerimientosController@AgregarCaracteristicaPropuesta');
            Route::post('/EnviaraDiseño','RequerimientosController@EnviaraDiseño');
















            //Backup
            Route::get('backup/download/{file_name}', 'BackupController@download');
            Route::get('backup/delete/{file_name}', 'BackupController@delete');
            Route::resource('backup', 'BackupController', ['only' => [
                'index', 'create', 'store'
            ]]);


            //Bitacora de operacion y mantenimiento de fuentes fijas
            Route::resource('bitacoraomff','BitacoraOmffController');
            Route::get('get_bitacoraomff','BitacoraOmffController@index');
            Route::get('create_bitacoraomff','BitacoraOmffController@Create');
            Route::post('save_bitacoraomff','BitacoraOmffController@Store');
            Route::get('get_details_bitacoraomff','BitacoraOmffController@Details');
            Route::get('get_chart_peer_day_bitacoraomff','BitacoraOmffController@chart_peer_day');
            Route::get('bitacoraomff_hl1','BitacoraOmffController@create_hl1');
            Route::post('save_bitacoraomff_hl1','BitacoraOmffController@Save_Hl1');
            Route::get('hl1_table_bitacoraomff','BitacoraOmffController@hl1');
            Route::get('Details_Hl1_bitacoraomff','BitacoraOmffController@Details_Hl1');


            Route::resource('informecontrolentrega', 'InformeControlEntregaController');
            Route::get('informecontrolentrega_get','InformeControlEntregaController@index');


            Route::resource('informeordenproduccion','InformeOrdenProduccionController');
            Route::get('informeordenproduccion_getdata','InformeOrdenProduccionController@index');


            Route::get('/informeordenproduccion_barcode','InformeOrdenProduccionController@Barcode');

            Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

            Route::get('get_materiales','ProdCievCodMaterialController@Materials');

            Route::resource('medida_prevencion','MedidaPrevencionController');
            Route::post('/validate_exist_employee','MedidaPrevencionController@validate_exist_employee');
            Route::get('/get_data_peer_day_medida_prevencion','MedidaPrevencionController@info');
            Route::post('/registry_temperature_in_day','MedidaPrevencionController@registry_temperature_in_day');
            Route::post('/exit_employee_in_day','MedidaPrevencionController@exit_employee_in_day');
            Route::get('/get_all_employees','MedidaPrevencionController@get_all_employees');
            Route::post('/medida_prevencion_edit_temperature','MedidaPrevencionController@edit_temperature');


            Route::resource('edit_medida_prevencion','EditMedidaPrevencionController');
            Route::post('edit_medida_prevencion_edit_time_enter','EditMedidaPrevencionController@edit_time_enter');
            Route::post('edit_medida_prevencion_edit_time_exit','EditMedidaPrevencionController@edit_time_exit');
            Route::post('edit_medida_prevencion_edit_temperature','EditMedidaPrevencionController@edit_temperature');
            Route::post('edit_medida_prevencion_edit_created_at','EditMedidaPrevencionController@edit_created_at');
            Route::post('download_informe_medida_prevencion','EditMedidaPrevencionController@download_informe');
            Route::post('edit_medida_prevencion_edit_status','EditMedidaPrevencionController@change_status');


            Route::get('/ingreso_cedula','MedidaPrevencionController@ingreso_cedula');
            Route::get('/consultar_empleado_invitado_cc','MedidaPrevencionController@consultar_empleado_invitado_cc');


            Route::resource('sensores','SensorChimeneaController',['only' => [
                'index'
            ]]);

            Route::get('sensores_chimenea','SensorChimeneaController@data_chimenea');
            Route::get('sensores_gas','SensorChimeneaController@data_gas');
        });





    });
});




