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
                    Route::get('/factura/edit/calcular_retencion','FacturacionElectronica\FacturasController@calcular_retencion');
                    Route::post('/factura_edit/guardar_facura','FacturacionElectronica\FacturasController@guardar_factura_edit');


                    /*notas credito*/
                    Route::resource('nota_credito','FacturacionElectronica\NotasCreditoController');
                    Route::post('/nota_credito/generar_xml','FacturacionElectronica\NotasCreditoController@generar_archivo_xml');


                    /*configuracion*/
                    Route::resource('configuracions','FacturacionElectronica\ConfiguracionController');
                    Route::post('configuracions/facturas','FacturacionElectronica\ConfiguracionController@guardar_config_facturas');
                    Route::post('configuracions/notas_credito','FacturacionElectronica\ConfiguracionController@guardar_config_notas_credito');
                    Route::post('configuracions/facturas_exportacion', 'FacturacionElectronica\ConfiguracionController@guardar_config_facturas_exportacion');
                    Route::post('configuracions/notas_credito_exportacion', 'FacturacionElectronica\ConfiguracionController@guardar_config_notas_exportacion');


                    /*web service*/
                    Route::post('/web_service/descargar_documento', 'FacturacionElectronica\WebServiceController@descarga_documento');
                    Route::post('/web_service/envio_facturas','FacturacionElectronica\WebServiceController@envio_facturas');
                    Route::post('/web_service/envio_notas_credito','FacturacionElectronica\WebServiceController@envio_notas_credito');
                    Route::get('/web_service/listado_documentos','FacturacionElectronica\WebServiceController@listado_documentos');
                    Route::get('/web_service/info_documento','FacturacionElectronica\WebServiceController@info_documento');
                    Route::get('/web_service/estado_dian','FacturacionElectronica\WebServiceController@estado_dian');
                    Route::post('/web_service/enviar_documento_electronico', 'FacturacionElectronica\WebServiceController@enviar_documento_electronico');


                    /*gestion*/
                    Route::resource('gestions','FacturacionElectronica\GestionController')->only('index');
                    Route::get('/gestions/comprobar_factura', 'FacturacionElectronica\GestionController@comprobar_factura');
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
                    Route::get('listar_tipo_cliente','Terceros\Clientes\ClientesController@listar_tipo_cliente');
                    Route::get('listar_actividad_economica','Terceros\Clientes\ClientesController@listar_actividad_economica');


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

                    Route::post('cliente/subir_rut','Terceros\Clientes\ClientesController@subir_rut');
                    Route::get('cliente/descargar_rut/{file}','Terceros\Clientes\ClientesController@descargar_rut')->name('descargar_rut');
                });



               /* Route::get('/ProductosEnTendenciaPorMes','GestionClientesController@ProductosEnTendenciaPorMes');
                Route::get('/FacturacionElectronicaGc','GestionClientesController@FacturacionElectronica');*/
                //edit items from clients

                Route::get('recibos_caja','Terceros\RecibosCaja\RecibosController@index')->name('recibos_caja.index');
                Route::prefix('recibos_caja')->group(function () {
                    Route::get('nuevo','Terceros\RecibosCaja\RecibosController@create')->name('recibos_caja.nuevo');
                    Route::get('cartera','Terceros\RecibosCaja\RecibosController@cartera')->name('recibos_caja.cartera');
                    Route::get('buscar_cliente','Terceros\RecibosCaja\RecibosController@buscar_cliente');
                    Route::get('consultar_recibos_cliente','Terceros\RecibosCaja\RecibosController@consultar_recibos_cliente');
                    Route::get('consultar_recibo','Terceros\RecibosCaja\RecibosController@consultar_recibo');
                    Route::get('consultar_tipo_venta', 'Terceros\RecibosCaja\RecibosController@consultar_tipo_venta');
                    Route::get('{recibo}/edit','Terceros\RecibosCaja\RecibosController@edit')->name('recibos_caja.edit');
                    Route::get('consultar_documento', 'Terceros\RecibosCaja\RecibosController@consultar_documento');
                    Route::post('guardar_recibo_caja','Terceros\RecibosCaja\RecibosController@guardar_recibo_caja');
                    Route::post('guardar_recibo_caja_edit','Terceros\RecibosCaja\RecibosController@guardar_recibo_caja_edit');
                    Route::post('cambiar_estado','Terceros\RecibosCaja\RecibosController@cambiar_estado');
                    Route::post('finalizar_rc','Terceros\RecibosCaja\RecibosController@finalizar_rc');
                    Route::get('datos_rc_informe', 'Terceros\RecibosCaja\RecibosController@datos_rc_informe');



                    Route::prefix('anticipo')->group(function () {
                        Route::get('nuevo','Terceros\RecibosCaja\AnticipoController@index')->name('recibos_caja.nuevo_anticipo');
                        Route::post('guardar_anticipo','Terceros\RecibosCaja\AnticipoController@store')->name('recibos_caja.guardar_anticipo');
                        Route::get('consultar_anticipo', 'Terceros\RecibosCaja\AnticipoController@consultar_anticipo');
                        Route::post('cambiar_estado','Terceros\RecibosCaja\AnticipoController@change_state');

                    });
                });


                Route::prefix('productos')->group(function () {
                    Route::prefix('maestros')->group(function () {

                        /*Tipo producto*/
                        Route::resource('tipo_producto','Productos\Maestros\TipoProductoController')->only('index','destroy','edit','store');
                        Route::post('/tipo_producto/validar_codigo', 'Productos\Maestros\TipoProductoController@validar_codigo');


                        /*Linea*/
                        Route::resource('linea','Productos\Maestros\LineaController')->only('index','destroy','edit','store');
                        Route::post('/linea/validar_codigo', 'Productos\Maestros\LineaController@validar_codigo');


                        /*Sublinea*/
                        Route::resource('sublinea','Productos\Maestros\SublineaController')->only('index','destroy','edit','store');
                        Route::get('/sublinea/unidades_medida','Productos\Maestros\SublineaController@unidades_medida');
                        Route::get('/sublinea/caracteristicas_unidades_medida','Productos\Maestros\SublineaController@caracteristicas_unidades_medida');
                        Route::post('/sublinea/validar_codigo', 'Productos\Maestros\SublineaController@validar_codigo');


                        /*Caracteristica*/
                        Route::resource('caracteristica','Productos\Maestros\CaracteristicaController')->only('index','destroy','edit','store');
                        Route::get('caracteristica/listar_sublineas', 'Productos\Maestros\CaracteristicaController@listar_sublineas');
                        Route::post('/caracteristica/validar_codigo', 'Productos\Maestros\CaracteristicaController@validar_codigo');


                        /*Material*/
                        Route::resource('material','Productos\Maestros\MaterialController')->only('index','destroy','edit','store');
                        Route::post('/material/validar_codigo', 'Productos\Maestros\MaterialController@validar_codigo');


                        /*Medida*/
                        Route::resource('medida','Productos\Maestros\MedidaController')->only('index','destroy','edit','store');
                        Route::get('/medida/listar_cara_y_unidad_medida','Productos\Maestros\MedidaController@listar_cara_y_unidad_medida');
                        Route::get('/medida/info_calculo_cod','Productos\Maestros\MedidaController@info_calculo_cod');
                        Route::post('/medida/validar_denominacion', 'Productos\Maestros\MedidaController@validar_denominacion');
                    });


                    /*Codificador*/
                    Route::resource('codificado', 'Productos\Codificador\CodificadorController')->only('index', 'destroy', 'store');
                    Route::get('/codificado/listar_sublineas', 'Productos\Codificador\CodificadorController@listar_sublineas');
                    Route::get('/codificado/listar_caracteristicas_materiales_medidas', 'Productos\Codificador\CodificadorController@listar_caracteristicas_materiales_medidas');
                    Route::get('/codificado/obtener_datos_generacion_cod_desc','Productos\Codificador\CodificadorController@obtener_datos_generacion_cod_desc');
                    Route::post('/codificado/validar_codigo', 'Productos\Codificador\CodificadorController@validar_codigo');


                    /*Clonador*/
                    Route::resource('clonado','Productos\Clonador\ClonadorController')->only('index', 'store');
                    Route::get('/clonado/obtener_info_producto_clonar', 'Productos\Clonador\ClonadorController@obtener_info_producto_clonar');
                    Route::get('/clonado/obtener_producto_codificador', 'Productos\Clonador\ClonadorController@obtener_producto_codificador');
                });


                /*Pedidos*/
                Route::prefix('pedidos')->group(function () {
                    /*ventas*/
                    Route::resource('venta','Pedidos\VentasController')->only('index', 'edit', 'create', 'store');
                    Route::post('/venta/enviar_cartera', 'Pedidos\VentasController@enviar_cartera');
                    Route::post('/venta/anular_pedido', 'Pedidos\VentasController@anular_pedido');
                    Route::post('/venta/re_abrir_pedido', 'Pedidos\VentasController@re_abrir_pedido');
                    Route::get('/venta/listar_productos_max', 'Pedidos\VentasController@listar_productos_max');
                    Route::get('/venta/listar_artes', 'Pedidos\VentasController@listar_artes');
                    Route::put('/venta/actualizar_pedido','Pedidos\VentasController@update');
                    Route::get('/venta/ver_pedido_pdf','Pedidos\VentasController@ver_pedido_pdf');
                    Route::get('/venta/info_area', 'Pedidos\VentasController@info_area');
                    Route::get('/venta/info_cliente', 'Pedidos\VentasController@info_cliente');


                    /*Cartera*/
                    Route::resource('cartera', 'Pedidos\CarteraController')->only('index');
                    Route::post('/cartera/actualizar_estado', 'Pedidos\CarteraController@actualizar_estado');

                    /*Costos*/
                    Route::resource('costos', 'Pedidos\CostosController')->only('index');
                    Route::post('/costos/actualizar_estado', 'Pedidos\CostosController@actualizar_estado');

                    /*Produccion*/
                    Route::resource('produccion', 'Pedidos\ProduccionController')->only('index');
                    Route::post('/produccion/actualizar_estado', 'Pedidos\ProduccionController@actualizar_estado');
                    Route::get('/produccion/listar_terminados', 'Pedidos\ProduccionController@listar_terminados');


                    /*Bodega*/
                    Route::resource('bodega', 'Pedidos\BodegaController')->only('index');
                    Route::post('/bodega/actualizar_estado', 'Pedidos\BodegaController@actualizar_pedido');
                });


                Route::prefix('requerimientos')->group(function () {
                    Route::resource('ventas', 'Requerimientos\RequerimientoController')->only('index','store', 'edit');
                    Route::get('ventas/listar_clientes', 'Requerimientos\RequerimientoController@listar_clientes');
                    Route::get('ventas/listar_marcas', 'Requerimientos\RequerimientoController@listar_marcas');
                    Route::get('ventas/listar_productos', 'Requerimientos\RequerimientoController@listar_productos');
                    Route::post('ventas/validar_marca','Requerimientos\RequerimientoController@validar_marca');
                    Route::post('ventas/guardar_marca','Requerimientos\RequerimientoController@guardar_marca');



                    Route::post('transaccion/eliminar_archivo', 'Requerimientos\TransactionController@eliminar_archivo');
                    Route::post('transaccion/subir_archivos_soporte', 'Requerimientos\TransactionController@subir_archivos_soporte');
                    Route::post('transaccion/enviar_render','Requerimientos\TransactionController@enviar_render');
                    Route::post('transaccion/solicitar_plano','Requerimientos\TransactionController@solicitar_plano');
                    Route::post('transaccion/cambiar_estado','Requerimientos\TransactionController@cambiar_estado');
                    Route::post('transaccion/anular','Requerimientos\TransactionController@anular');
                    Route::post('transaccion/finalizar','Requerimientos\TransactionController@finalizar');
                    Route::get('transaccion/listar_disenadores','Requerimientos\TransactionController@listar_disenadores');
                    Route::post('transaccion/cambiar_disenador','Requerimientos\TransactionController@cambiar_disenador');
                    Route::post('transaccion/enviar_diseno','Requerimientos\TransactionController@enviar_diseno');
                    Route::post('transaccion/agregar_comentario','Requerimientos\TransactionController@agregar_comentario');
                    Route::get('transaccion/listar_productos', 'Requerimientos\TransactionController@listar_productos');
                    Route::post('transaccion/agregar_propuesta','Requerimientos\TransactionController@agregar_propuesta');
                    Route::get('transaccion/descargar_soporte/{id}/{file}','Requerimientos\TransactionController@descargar_archivo_soporte')->name('transaccion.descargar.soporte');
                    Route::get('transaccion/obtener_datos_propuesta','Requerimientos\TransactionController@obtener_datos_propuesta');
                    Route::post('transaccion/subir_archivo_2d','Requerimientos\TransactionController@subir_archivo_2d');
                    Route::post('transaccion/subir_archivo_3d','Requerimientos\TransactionController@subir_archivo_3d');
                    Route::post('transaccion/subir_archivo_plano','Requerimientos\TransactionController@subir_archivo_plano');
                    Route::post('transaccion/agregar_comentario_propuesta', 'Requerimientos\TransactionController@agregar_comentario_propuesta');

                    Route::post('transaccion/aprobar_propuesta', 'Requerimientos\TransactionController@aprobar_propuesta');
                    Route::post('transaccion/rechazar_propuesta', 'Requerimientos\TransactionController@rechazar_propuesta');
                    Route::post('transaccion/enviar_aprobar_propuesta', 'Requerimientos\TransactionController@enviar_aprobar_propuesta');

                    Route::get('transaccion/comprobar_estado_propuesta', 'Requerimientos\TransactionController@comprobar_estado_propuesta');
                    Route::post('transaccion/finalizar_propuesta', 'Requerimientos\TransactionController@finalizar_propuesta');


                    Route::get('diseno_grafico', 'Requerimientos\DisenoController@index')->name('requerimientos.diseno_grafico');
                    Route::get('render', 'Requerimientos\RenderController@index')->name('requerimientos.render');
                    Route::get('plano', 'Requerimientos\PlanoController@index')->name('requerimientos.plano');


                });






                Route::prefix('mesa_ayuda')->group(function () {
                    Route::get('requerimientos_admon', 'MesaAyuda\MesaAyudaController@requerimientos_admon')->name('mesa_ayuda.requerimientos_admon');
                });



            });



            /*Backups*/
            Route::get('backup/download/{file_name}', 'BackupController@download');
            Route::get('backup/delete/{file_name}', 'BackupController@delete');
            Route::resource('backup', 'BackupController', ['only' => [
                'index', 'create', 'store'
            ]]);


            /*Home*/
            Route::get('/home', 'HomeController@index')->name('home');

            /*roles y permisos*/
            Route::resource('roles', 'RoleController');
            Route::resource('permissions', 'PermissionController');
            Route::resource('permission_groups', 'PermissionGroupController');
            Route::resource('users', 'UserController');
            Route::resource('categories', 'CategoryController');
            Route::resource('tags', 'TagController');
            Route::resource('posts', 'PostController');
















            Route::get('/get-user-chart-data','ChartDataController@getMonthlyUserData');
            Route::get('/get-invoice-chart-data','ChartDataController@getMonthlyInvoiceData');
            Route::get('/get-invoice-chart-data-value','ChartDataController@getMonthlyInvoiceDataValue');
            Route::get('/get-invoice-age-data-value','ChartDataController@getAgeInvoiceData');
            Route::get('/get-invoice-day-data-value','ChartDataController@getDayInvoiceData');



            Route::resource('pronosticos','PronosticoController');
            Route::get('/PronosticosIndex','PronosticoController@index');
            Route::get('/PronosticosInventory','PronosticoController@Inventory');
            Route::get('/PronosticosCantCompr','PronosticoController@CantCompro');
            Route::get('/PronosticosDetailsLots','PronosticoController@DetailsLots');
            Route::get('/PronosticosPronostics','PronosticoController@Pronostics');
            Route::get('/Pronostico_para_cerrar','PronosticoController@Pronostico_para_cerrar');
            Route::post('/cerrar_pronosticos','PronosticoController@cerrar_pronosticos');





            Route::resource('Requerimientoss','RequerimientosController');
            Route::get('/misrequerimientos','RequerimientosController@MisRequerimientos');
            Route::resource('requerimientos_dashboard','RequerimientosChartsController');
            Route::get('/req_dash_requerimientosxdiseñador','RequerimientosChartsController@RequerimientosxDiseñador');
            Route::get('/req_dash_Prop_x_Estado','RequerimientosChartsController@Est_Propuestas');
            Route::get('/req_dash_All_Req','RequerimientosChartsController@All_req_est');








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



            Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


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


            Route::resource('sensores','SensorChimeneaController')->only('index');

            Route::get('sensores_chimenea','SensorChimeneaController@data_chimenea');
            Route::get('sensores_gas','SensorChimeneaController@data_gas');
        });



    });




