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

use App\Http\Controllers\Artes\ArtesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BitacoraOmffController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Comercial\DashboardController;
use App\Http\Controllers\Comercial\EventoController;
use App\Http\Controllers\Consulta\FacturaElectronicaController;
use App\Http\Controllers\EditMedidaPrevencionController;
use App\Http\Controllers\FacturacionElectronica\ConfiguracionController;
use App\Http\Controllers\FacturacionElectronica\FacturasController;
use App\Http\Controllers\FacturacionElectronica\GestionController;
use App\Http\Controllers\FacturacionElectronica\NotasCreditoController;
use App\Http\Controllers\FacturacionElectronica\WebServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedidaPrevencionController;
use App\Http\Controllers\MesaAyuda\MesaAyudaController;
use App\Http\Controllers\Pedidos\BodegaController;
use App\Http\Controllers\Pedidos\CarteraController;
use App\Http\Controllers\Pedidos\CostosController;
use App\Http\Controllers\Pedidos\ProduccionController;
use App\Http\Controllers\Pedidos\TroquelesController;
use App\Http\Controllers\Pedidos\VentasController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Productos\Calidad\CentroTrabajoController;
use App\Http\Controllers\Productos\Clonador\ClonadorController;
use App\Http\Controllers\Productos\Codificador\CodificadorController;
use App\Http\Controllers\Productos\Maestros\CaracteristicaController;
use App\Http\Controllers\Productos\Maestros\LineaController;
use App\Http\Controllers\Productos\Maestros\MaterialController;
use App\Http\Controllers\Productos\Maestros\MedidaController;
use App\Http\Controllers\Productos\Maestros\SublineaController;
use App\Http\Controllers\Productos\Maestros\TipoProductoController;
use App\Http\Controllers\PronosticoController;
use App\Http\Controllers\Requerimientos\DisenoController;
use App\Http\Controllers\Requerimientos\PlanoController;
use App\Http\Controllers\Requerimientos\RenderController;
use App\Http\Controllers\Requerimientos\RequerimientoController;
use App\Http\Controllers\Requerimientos\TransactionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SensorChimeneaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Terceros\Clientes\ClientesController;
use App\Http\Controllers\Terceros\RecibosCaja\AnticipoController;
use App\Http\Controllers\Terceros\RecibosCaja\RecibosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Productos\Calidad\DashboardController as DashboardProductos;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;


Route::get('/', [BlogController::class, 'index'])->name('blog');
Route::get('/post/{post}', [BlogController::class, 'post'])->name('post');
Route::get('/post/tag/{tag}', [BlogController::class, 'tag'])->name('tag');
Route::get('/post/category/{category}', [BlogController::class, 'category'])->name('category');


/*Auth::routes();*/
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('login/locked', [LoginController::class, 'locked'])->middleware('auth')->name('login.locked');
Route::post('login/locked', [LoginController::class, 'unlock'])->name('login.unlock');



Route::middleware(['auth'])->group(function() {
    Route::middleware(['auth.lock'])->group(function() {

        Route::prefix('home')->group(function () {
            /* accesos remotos */
            route::get('/accesos_remotos', [HomeController::class, 'accesosremotos'])->name('accesos_remotos.index');
        });


        Route::prefix('aplicaciones')->group(function () {

            /*Facturacion electronica*/
            Route::prefix('facturacion_electronica')->group(function () {

                /*facturas*/
                Route::resource('factura',FacturasController::class);
                Route::post('/factura/generar_xml', [FacturasController::class, 'generar_archivo_xml']);
                Route::get('/factura/edit/calcular_retencion', [FacturasController::class, 'calcular_retencion']);
                Route::post('/factura_edit/guardar_facura', [FacturasController::class, 'guardar_factura_edit']);


                /*notas credito*/
                Route::resource('nota_credito',NotasCreditoController::class);
                Route::post('/nota_credito/generar_xml', [NotasCreditoController::class, 'generar_archivo_xml']);


                /*configuracion*/
                Route::resource('configuracions',ConfiguracionController::class);
                Route::post('configuracions/facturas', [ConfiguracionController::class, 'guardar_config_facturas']);
                Route::post('configuracions/notas_credito', [ConfiguracionController::class, 'guardar_config_notas_credito']);
                Route::post('configuracions/facturas_exportacion', [ConfiguracionController::class, 'guardar_config_facturas_exportacion']);
                Route::post('configuracions/notas_credito_exportacion', [ConfiguracionController::class, 'guardar_config_notas_exportacion']);


                /*web service*/
                Route::post('/web_service/descargar_documento', [WebServiceController::class, 'descarga_documento']);
                Route::post('/web_service/envio_facturas', [WebServiceController::class, 'envio_facturas']);
                Route::post('/web_service/envio_notas_credito', [WebServiceController::class, 'envio_notas_credito']);
                Route::get('/web_service/listado_documentos', [WebServiceController::class, 'listado_documentos']);
                Route::get('/web_service/info_documento', [WebServiceController::class, 'info_documento']);
                Route::get('/web_service/estado_dian', [WebServiceController::class, 'estado_dian']);
                Route::post('/web_service/enviar_documento_electronico', [WebServiceController::class, 'enviar_documento_electronico']);


                /*gestion*/
                Route::resource('gestions',GestionController::class)->only('index');
                Route::get('/gestions/comprobar_factura', [GestionController::class, 'comprobar_factura']);
            });


            /* artes */
            Route::resource('arte',ArtesController::class)->only('index');


            /* Gestion de terceros */
            Route::prefix('terceros')->group(function () {
                Route::resource('cliente',ClientesController::class)->only('index');

                Route::get('listar_ciudades', [ClientesController::class, 'listar_ciudades']);
                Route::get('listar_departamentos', [ClientesController::class, 'listar_departamentos']);
                Route::get('listar_plazos', [ClientesController::class, 'listar_plazos']);
                Route::get('listar_vendedores', [ClientesController::class, 'listar_vendedores']);
                Route::get('listar_tipo_cliente', [ClientesController::class, 'listar_tipo_cliente']);
                Route::get('listar_actividad_economica', [ClientesController::class, 'listar_actividad_economica']);


                Route::prefix('cliente')->group(function () {
                    Route::get('nuevo', [ClientesController::class, 'nuevo']);
                    Route::get('buscar_cliente', [ClientesController::class, 'buscar_cliente']);
                    Route::get('editar/{cliente}/show', [ClientesController::class, 'show']);
                    Route::post('guardar_cliente', [ClientesController::class, 'guardar_cliente']);
                    Route::get('obtener_log_cambios', [ClientesController::class, 'obtener_log_cambios']);
                    Route::post('subir_rut', [ClientesController::class, 'subir_rut']);
                    Route::get('descargar_rut/{file}', [ClientesController::class, 'descargar_rut'])->name('descargar_rut');
                    Route::post('crear_actividad_economica',  [ClientesController::class, 'crear_actividad_economica']);


                    Route::prefix('actualizar')->group(function () {
                        /*actualizacion de datos de cliente*/
                        Route::post('actualizar_direccion1', [ClientesController::class, 'actualizar_direccion1']);
                        Route::post('actualizar_direccion2', [ClientesController::class, 'actualizar_direccion2']);
                        Route::post('actualizar_moneda', [ClientesController::class, 'actualizar_moneda']);
                        Route::post('cambiar_tipo_cliente', [ClientesController::class, 'cambiar_tipo_cliente']);
                        Route::post('actualizar_contacto', [ClientesController::class, 'actualizar_contacto']);
                        Route::post('actualizar_telefono1', [ClientesController::class, 'actualizar_telefono1']);
                        Route::post('actualizar_telefono2', [ClientesController::class, 'actualizar_telefono2']);
                        Route::post('actualizar_celular', [ClientesController::class, 'actualizar_celular']);
                        Route::post('actualizar_email_contacto', [ClientesController::class, 'actualizar_email_contacto']);
                        Route::post('actualizar_email_facturacion_electronica', [ClientesController::class, 'actualizar_email_facturacion_electronica']);
                        Route::post('actualizar_termino_pago', [ClientesController::class, 'actualizar_termino_pago']);
                        Route::post('actualizar_descuento', [ClientesController::class, 'actualizar_descuento']);
                        Route::post('actualizar_vendedor', [ClientesController::class, 'actualizar_vendedor']);
                        Route::post('actualizar_correos_copia', [ClientesController::class, 'actualizar_correos_copia']);
                        Route::post('actualizar_rut', [ClientesController::class, 'actualizar_rut']);
                        Route::post('actualizar_gran_contribuyente', [ClientesController::class, 'actualizar_gran_contribuyente']);
                        Route::post('actualizar_responsable_iva', [ClientesController::class, 'actualizar_responsable_iva']);
                        Route::post('actualizar_responsable_facturacion_electronica', [ClientesController::class, 'actualizar_responsable_facturacion_electronica']);
                        Route::post('actualizar_telefono_facturacion_electronica', [ClientesController::class, 'actualizar_telefono_facturacion_electronica']);
                        Route::post('actualizar_codigo_ciudad_ext', [ClientesController::class, 'actualizar_codigo_ciudad_ext']);
                        Route::post('actualizar_grupo_economico', [ClientesController::class, 'actualizar_grupo_economico']);
                    });
                });





                Route::prefix('comercial')->group(function () {
                    Route::get('eventos_actividades', [EventoController::class, 'index'])->name('eventos_actividades');
                    Route::get('obtener_eventos', [EventoController::class, 'obtener_eventos']);
                    Route::post('guardar_evento', [EventoController::class, 'store']);


                    Route::get('dashboard', [DashboardController::class, 'index'])->name('comercial.dashboard');
                    Route::prefix('dashboard')->group(function () {
                        Route::get('consultar_clientes', [DashboardController::class, 'consultar_clientes']);
                        Route::get('consultar_info_cliente', [DashboardController::class, 'consultar_info_cliente']);
                        Route::post('guardar_evento', [DashboardController::class, 'store']);
                    });
                });
            });



           /* Route::get('/ProductosEnTendenciaPorMes','GestionClientesController@ProductosEnTendenciaPorMes');
            Route::get('/FacturacionElectronicaGc','GestionClientesController@FacturacionElectronica');*/
            //edit items from clients

            Route::get('recibos_caja',[RecibosController::class, 'index'])->name('recibos_caja.index');
            Route::prefix('recibos_caja')->group(function () {
                Route::get('nuevo', [RecibosController::class, 'create'])->name('recibos_caja.nuevo');
                Route::get('cartera', [RecibosController::class, 'cartera'])->name('recibos_caja.cartera');
                Route::get('buscar_cliente', [RecibosController::class, 'buscar_cliente']);
                Route::get('consultar_recibos_cliente', [RecibosController::class, 'consultar_recibos_cliente']);
                Route::get('consultar_recibo', [RecibosController::class, 'consultar_recibo']);
                Route::get('consultar_tipo_venta', [RecibosController::class, 'consultar_tipo_venta']);
                Route::get('{recibo}/edit', [RecibosController::class, 'edit'])->name('recibos_caja.edit');
                Route::get('consultar_documento', [RecibosController::class, 'consultar_documento']);
                Route::post('guardar_recibo_caja', [RecibosController::class, 'guardar_recibo_caja']);
                Route::post('guardar_recibo_caja_edit', [RecibosController::class, 'guardar_recibo_caja_edit']);
                Route::post('cambiar_estado', [RecibosController::class, 'cambiar_estado']);
                Route::post('finalizar_rc', [RecibosController::class, 'finalizar_rc']);
                Route::get('datos_rc_informe', [RecibosController::class, 'datos_rc_informe']);



                Route::prefix('anticipo')->group(function () {
                    Route::get('nuevo', [AnticipoController::class , 'index'])->name('recibos_caja.nuevo_anticipo');
                    Route::post('guardar_anticipo',[AnticipoController::class , 'store'])->name('recibos_caja.guardar_anticipo');
                    Route::get('consultar_anticipo', [AnticipoController::class , 'consultar_anticipo']);
                    Route::post('cambiar_estado',[AnticipoController::class , 'change_state']);
                    Route::post('finalizar_anticipo',[AnticipoController::class , 'finalizar_anticipo']);
                    Route::get('{recibo}/edit',[AnticipoController::class , 'edit'])->name('recibos_caja_anticipo.edit');

                });
            });


            Route::prefix('productos')->group(function () {
                Route::prefix('maestros')->group(function () {

                    /*Tipo producto*/
                    Route::resource('tipo_producto',TipoProductoController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::post('/tipo_producto/validar_codigo', [TipoProductoController::class, 'validar_codigo']);


                    /*Linea*/
                    Route::resource('linea',LineaController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::post('/linea/validar_codigo', [LineaController::class, 'validar_codigo']);


                    /*Sublinea*/
                    Route::resource('sublinea',SublineaController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::get('/sublinea/unidades_medida', [SublineaController::class, 'unidades_medida']);
                    Route::get('/sublinea/caracteristicas_unidades_medida', [SublineaController::class, 'caracteristicas_unidades_medida']);
                    Route::post('/sublinea/validar_codigo', [SublineaController::class, 'validar_codigo']);


                    /*Caracteristica*/
                    Route::resource('caracteristica',CaracteristicaController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::get('caracteristica/listar_sublineas', [CaracteristicaController::class, 'listar_sublineas']);
                    Route::post('/caracteristica/validar_codigo', [CaracteristicaController::class, 'validar_codigo']);


                    /*Material*/
                    Route::resource('material',MaterialController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::post('/material/validar_codigo', [MaterialController::class, 'validar_codigo']);


                    /*Medida*/
                    Route::resource('medida',MedidaController::class)->only('index', 'destroy', 'edit', 'store');
                    Route::get('/medida/listar_cara_y_unidad_medida', [MedidaController::class,'listar_cara_y_unidad_medida']);
                    Route::get('/medida/info_calculo_cod',[MedidaController::class,'info_calculo_cod']);
                    Route::post('/medida/validar_denominacion', [MedidaController::class,'validar_denominacion']);
                });


                /*Codificador*/
                Route::resource('codificado', CodificadorController::class)->only('index', 'destroy', 'store');
                Route::prefix('codificado')->group(function () {
                    Route::get('/listar_lineas', [CodificadorController::class, 'listar_lineas']);
                    Route::get('/listar_sublineas', [CodificadorController::class, 'listar_sublineas']);
                    Route::get('/listar_caracteristicas_materiales_medidas', [CodificadorController::class, 'listar_caracteristicas_materiales_medidas']);
                    Route::get('/obtener_datos_generacion_cod_desc', [CodificadorController::class, 'obtener_datos_generacion_cod_desc']);
                    Route::post('/validar_codigo', [CodificadorController::class, 'validar_codigo']);
                });



                /*Clonador*/
                Route::resource('clonado',ClonadorController::class)->only('index', 'store');
                Route::get('/clonado/obtener_info_producto_clonar', [ClonadorController::class, 'obtener_info_producto_clonar']);
                Route::get('/clonado/obtener_producto_codificador', [ClonadorController::class, 'obtener_producto_codificador']);



                /*Control de calidad*/
                Route::prefix('calidad')->group(function () {
                    Route::get('revision', [CentroTrabajoController::class, 'index'])->name('calidad.revision_op');
                    Route::prefix('revision')->group(function () {
                        Route::get('consultar_op', [CentroTrabajoController::class, 'consultar_op']);
                        Route::post('guardar', [CentroTrabajoController::class, 'store']);
                        Route::get('info_review', [CentroTrabajoController::class, 'info_review']);
                        Route::get('consultar_descripcion_centro_trabajo', [CentroTrabajoController::class, 'consultar_descripcion_centro_trabajo']);
                    });


                    Route::get('dashboard', [DashboardProductos::class, 'index']);

                    Route::prefix('dashboard')->group(function () {
                        Route::get('consultar_bimestre', [DashboardProductos::class, 'consultar_bimestre']);

                    });
                });
            });


            /*Pedidos*/
            Route::prefix('pedidos')->group(function () {
                /*ventas*/
                Route::resource('venta',VentasController::class)->only('index', 'edit', 'create', 'store');
                Route::prefix('venta')->group(function () {
                    Route::post('/enviar_cartera', [VentasController::class, 'enviar_cartera']);
                    Route::post('/anular_pedido', [VentasController::class, 'anular_pedido']);
                    Route::post('/re_abrir_pedido', [VentasController::class, 're_abrir_pedido']);
                    Route::get('/listar_productos_max', [VentasController::class, 'listar_productos_max']);
                    Route::get('/listar_artes', [VentasController::class, 'listar_artes']);
                    Route::get('/listar_marcas', [VentasController::class, 'listar_marcas']);
                    Route::put('/actualizar_pedido', [VentasController::class, 'update']);
                    Route::get('/ver_pedido_pdf', [VentasController::class, 'ver_pedido_pdf']);
                    Route::get('/info_area', [VentasController::class, 'info_area']);
                    Route::get('/info_cliente', [VentasController::class, 'info_cliente']);
                    Route::post('/clonar_pedido', [VentasController::class, 'clonar_pedido']);
                    Route::get('/listar_clientes', [VentasController::class, 'listar_clientes']);
                });



                /*Cartera*/
                Route::resource('cartera', CarteraController::class)->only('index');
                Route::post('/cartera/actualizar_estado', [CarteraController::class, 'actualizar_estado']);

                /*Costos*/
                Route::resource('costos', CostosController::class)->only('index');
                Route::post('/costos/actualizar_estado', [CostosController::class, 'actualizar_estado']);

                /*Produccion*/
                Route::resource('produccion', ProduccionController::class)->only('index');
                Route::post('/produccion/actualizar_estado', [ProduccionController::class, 'actualizar_estado']);
                Route::get('/produccion/listar_terminados', [ProduccionController::class, 'listar_terminados']);


                /*Bodega*/
                Route::resource('bodega',  BodegaController::class)->only('index');
                Route::post('/bodega/actualizar_estado', [BodegaController::class, 'actualizar_pedido']);

                /*Troqueles*/
                Route::resource('troqueles', TroquelesController::class)->only('index');
                Route::post('/troqueles/actualizar_estado', [TroquelesController::class, 'actualizar_pedido']);
            });


            Route::prefix('requerimientos')->group(function () {
                Route::resource('ventas', RequerimientoController::class)->only('index', 'store', 'edit');


                Route::prefix('ventas')->group(function () {
                    Route::get('listar_clientes', [RequerimientoController::class, 'listar_clientes']);
                    Route::get('listar_marcas', [RequerimientoController::class, 'listar_marcas']);
                    Route::get('listar_productos', [RequerimientoController::class, 'listar_productos']);
                    Route::post('validar_marca', [RequerimientoController::class, 'validar_marca']);
                    Route::post('guardar_marca', [RequerimientoController::class, 'guardar_marca']);
                });


                Route::prefix('transaccion')->group(function () {
                    Route::post('eliminar_archivo', [TransactionController::class, 'eliminar_archivo']);
                    Route::post('subir_archivos_soporte', [TransactionController::class, 'subir_archivos_soporte']);
                    Route::post('enviar_render', [TransactionController::class, 'enviar_render']);
                    Route::post('solicitar_plano', [TransactionController::class, 'solicitar_plano']);
                    Route::post('cambiar_estado', [TransactionController::class, 'cambiar_estado']);
                    Route::post('anular', [TransactionController::class, 'anular']);
                    Route::post('finalizar', [TransactionController::class, 'finalizar']);
                    Route::get('listar_disenadores', [TransactionController::class, 'listar_disenadores']);
                    Route::post('cambiar_disenador', [TransactionController::class, 'cambiar_disenador']);
                    Route::post('enviar_diseno', [TransactionController::class, 'enviar_diseno']);
                    Route::post('agregar_comentario', [TransactionController::class, 'agregar_comentario']);
                    Route::get('listar_productos', [TransactionController::class, 'listar_productos']);
                    Route::post('agregar_propuesta', [TransactionController::class, 'agregar_propuesta']);
                    Route::get('descargar_soporte/{id}/{file}', [TransactionController::class, 'descargar_archivo_soporte'])->name('transaccion.descargar.soporte');
                    Route::get('obtener_datos_propuesta', [TransactionController::class, 'obtener_datos_propuesta']);
                    Route::post('subir_archivo_2d', [TransactionController::class, 'subir_archivo_2d']);
                    Route::post('subir_archivo_3d', [TransactionController::class, 'subir_archivo_3d']);
                    Route::post('subir_archivo_plano', [TransactionController::class, 'subir_archivo_plano']);
                    Route::post('agregar_comentario_propuesta', [TransactionController::class, 'agregar_comentario_propuesta']);

                    Route::post('aprobar_propuesta', [TransactionController::class, 'aprobar_propuesta']);
                    Route::post('rechazar_propuesta', [TransactionController::class, 'rechazar_propuesta']);
                    Route::post('enviar_aprobar_propuesta', [TransactionController::class, 'enviar_aprobar_propuesta']);

                    Route::get('comprobar_estado_propuesta', [TransactionController::class, 'comprobar_estado_propuesta']);
                    Route::post('finalizar_propuesta', [TransactionController::class, 'finalizar_propuesta']);
                });


                Route::get('diseno_grafico', [DisenoController::class, 'index'])->name('requerimientos.diseno_grafico');
                Route::get('render', [RenderController::class, 'index'])->name('requerimientos.render');
                Route::get('plano', [PlanoController::class, 'index'])->name('requerimientos.plano');
            });


            Route::prefix('mesa_ayuda')->group(function () {
                Route::get('requerimientos_admon', [MesaAyudaController::class, 'requerimientos_admon'])->name('mesa_ayuda.requerimientos_admon');
            });

            /*Route::get('consultas', function () {
                return view('aplicaciones.consultas.index');
            });*/


            Route::prefix('consultas')->group(function () {
                Route::get('reenvio_facturas', [FacturaElectronicaController::class, 'index'])->name('consultas.reenvio_facturas');
                Route::post('verificar_documento', [FacturaElectronicaController::class, 'obtener_factura']);
            });


            Route::prefix('CRM')->group(function (){
                Route::prefix('comercial')->group(function (){
                    Route::get('visitas_actividades','CRM\EventVisitController@index');
                    Route::get('get_all_events_and_activities', 'CRM\EventVisitController@get_all_events_and_activities');
                    Route::get('get_events_and_activities', 'CRM\EventVisitController@get_events_and_activities');

                });
            });

        });



        /*Backups*/
        Route::get('backup/download/{file_name}', [BackupController::class, 'download'])->name('backup.download');
        Route::get('backup/delete/{file_name}',  [BackupController::class, 'delete']);
        Route::resource('backup', BackupController::class)->only('index', 'create', 'store');


        /*Home*/
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /*roles y permisos*/
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('permission_groups', PermissionGroupController::class);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('posts', PostController::class);





/*
        Route::get('/get-user-chart-data','ChartDataController@getMonthlyUserData');
        Route::get('/get-invoice-chart-data','ChartDataController@getMonthlyInvoiceData');
        Route::get('/get-invoice-chart-data-value','ChartDataController@getMonthlyInvoiceDataValue');
        Route::get('/get-invoice-age-data-value','ChartDataController@getAgeInvoiceData');
        Route::get('/get-invoice-day-data-value','ChartDataController@getDayInvoiceData');
*/



        Route::resource('pronosticos',PronosticoController::class);
        Route::get('/PronosticosIndex', [PronosticoController::class, 'index']);
        Route::get('/PronosticosInventory', [PronosticoController::class, 'Inventory']);
        Route::get('/PronosticosCantCompr', [PronosticoController::class, 'CantCompro']);
        Route::get('/PronosticosDetailsLots', [PronosticoController::class, 'DetailsLots']);
        Route::get('/PronosticosPronostics', [PronosticoController::class, 'Pronostics']);
        Route::get('/Pronostico_para_cerrar', [PronosticoController::class, 'Pronostico_para_cerrar']);
        Route::post('/cerrar_pronosticos', [PronosticoController::class, 'cerrar_pronosticos']);






        //Bitacora de operacion y mantenimiento de fuentes fijas
        Route::resource('bitacoraomff',BitacoraOmffController::class);
        Route::get('get_bitacoraomff', [BitacoraOmffController::class, 'index']);
        Route::get('create_bitacoraomff', [BitacoraOmffController::class, 'Create']);
        Route::post('save_bitacoraomff', [BitacoraOmffController::class, 'Store']);
        Route::get('get_details_bitacoraomff', [BitacoraOmffController::class, 'Details']);
        Route::get('get_chart_peer_day_bitacoraomff', [BitacoraOmffController::class, 'chart_peer_day']);
        Route::get('bitacoraomff_hl1', [BitacoraOmffController::class, 'create_hl1']);
        Route::post('save_bitacoraomff_hl1', [BitacoraOmffController::class, 'Save_Hl1']);
        Route::get('hl1_table_bitacoraomff', [BitacoraOmffController::class, 'hl1']);
        Route::get('Details_Hl1_bitacoraomff', [BitacoraOmffController::class, 'Details_Hl1']);



        Route::get('logs', [LogViewerController::class, 'index']);


        Route::resource('medida_prevencion',MedidaPrevencionController::class);
        Route::post('/validate_exist_employee', [MedidaPrevencionController::class, 'validate_exist_employee']);
        Route::get('/get_data_peer_day_medida_prevencion', [MedidaPrevencionController::class, 'info']);
        Route::post('/registry_temperature_in_day', [MedidaPrevencionController::class, 'registry_temperature_in_day']);
        Route::post('/exit_employee_in_day', [MedidaPrevencionController::class, 'exit_employee_in_day']);
        Route::get('/get_all_employees', [MedidaPrevencionController::class, 'get_all_employees']);
        Route::post('/medida_prevencion_edit_temperature', [MedidaPrevencionController::class, 'edit_temperature']);


        Route::resource('edit_medida_prevencion',EditMedidaPrevencionController::class);
        Route::post('edit_medida_prevencion_edit_time_enter', [EditMedidaPrevencionController::class, 'edit_time_enter']);
        Route::post('edit_medida_prevencion_edit_time_exit', [EditMedidaPrevencionController::class, 'edit_time_exit']);
        Route::post('edit_medida_prevencion_edit_temperature', [EditMedidaPrevencionController::class, 'edit_temperature']);
        Route::post('edit_medida_prevencion_edit_created_at', [EditMedidaPrevencionController::class, 'edit_created_at']);
        Route::post('download_informe_medida_prevencion', [EditMedidaPrevencionController::class, 'download_informe']);
        Route::post('edit_medida_prevencion_edit_status', [EditMedidaPrevencionController::class, 'change_status']);


        Route::get('/ingreso_cedula', [MedidaPrevencionController::class, 'ingreso_cedula']);
        Route::get('/consultar_empleado_invitado_cc', [MedidaPrevencionController::class, 'consultar_empleado_invitado_cc']);


        Route::resource('sensores',SensorChimeneaController::class)->only('index');

        Route::get('sensores_chimenea', [SensorChimeneaController::class, 'data_chimenea']);
        Route::get('sensores_gas', [SensorChimeneaController::class, 'data_gas']);
    });

});




