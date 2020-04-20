@extends('layouts.architectui')

@section('page_title', 'Accesos Remotos')

@section('module_title', 'Accesos Remotos')

@section('subtitle', 'Acceso a aplicaciones externas .')

@section('content')
    @can('aplicativos_externos')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Aplicaciones
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @can('aplicativos_externos.gestionar_clientes_max')
                                        <a href="http://192.168.1.53:81/intraciev/cartera/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-user-tie fa-3x"></i><br> Gestionar clientes MAX </a>
                                    @endcan
                                    @can('aplicativos_externos.ev_tickets')
                                        <a href="http://192.168.1.5/ev-tickets/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-ticket-alt fa-3x"></i><br> Tickets </a>
                                    @endcan
                                    @can('aplicativos_externos.mantenimiento')
                                        <a href="http://192.168.1.65/auth/login" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-tools fa-3x"></i><br> Mantenimiento </a>
                                    @endcan
                                    @can('aplicativos_externos.creacion_articulos')
                                        <a href="http://192.168.1.5/intranetev/index.php/aplicaciones-informaticas/creacion-de-articulos" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-box-open fa-3x"></i><br> Creacion articulos </a>
                                    @endcan
                                    @can('aplicativos_externos.reque_2d_3d')
                                        <a href="http://192.168.1.12/intranet_ci" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-palette fa-3x"></i><br> Requerimientos 2D - 3D </a>
                                    @endcan
                                    @can('aplicativos_externos.admin_diseños_2d')
                                        <a href="http://192.168.1.54:81/intraciev/artes/listaartes.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-paint-brush fa-3x"></i><br> Administrar diseños 2D </a>
                                    @endcan
                                    @can('aplicativos_externos.tranferencia_inventarios')
                                        <a href="http://192.168.1.53:81/intraciev/puntosventa/parametrizacion.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-dolly-flatbed fa-3x"></i><br> Transferencia Inventarios </a>
                                    @endcan
                                    @can('aplicativos_externos.glpi')
                                        <a href="http://192.168.1.5/ev-glpi/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-headset fa-3x"></i><br> Gestion TI </a>
                                    @endcan
                                    @can('aplicativos_externos.admin_gestion_facturacion')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-file-invoice-dollar fa-3x"></i><br> Transferencia de facturacion </a>
                                    @endcan
                                    @can('aplicativos_externos.pedidos_ev')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/ordenes/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-store fa-3x"></i><br> Pedidos EV </a>
                                    @endcan
                                    @can('aplicativos_externos.recibos_caja')
                                        <a href="http://192.168.1.54:81/intranet_ci/rc" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-cash-register fa-3x"></i><br> Recibos de caja </a>
                                    @endcan
                                    @can('aplicativos_externos.ensamble_externo')
                                        <a href="http://192.168.1.53:81/intraciev/ensambladores/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-screwdriver fa-3x"></i><br> Ensamble externo </a>
                                    @endcan
                                    @can('aplicativos_externos.etiquetas')
                                        <a href="http://192.168.1.5/ev-piu/Etiquetas" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-barcode fa-3x"></i><br> Etiquetado </a>
                                    @endcan
                                    @can('aplicativos_externos.admin_estruc_product')
                                        <a href="http://192.168.1.53:81/intraciev/produccion/estructuras/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-project-diagram fa-3x"></i><br> Estructura de producto </a>
                                    @endcan
                                    @can('aplicativos_externos.remisiones_ev')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/remisiones/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-book fa-3x"></i><br> Remisiones </a>
                                    @endcan
                                    @can('aplicativos_externos.remisiones_puntos_venta')
                                        <a href="http://192.168.1.53:81/intraciev/puntosventa/remisiones/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-receipt fa-3x"></i><br> Remisiones puntos de venta </a>
                                    @endcan
                                    @can('aplicativos_externos.control_salida_equipos')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/salidaequipos/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-laptop-medical fa-3x"></i><br> Control de salida equipos TI </a>
                                    @endcan
                                    @can('aplicativos_externos.auditoria_ev')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/auditoriaov/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-tasks fa-3x"></i><br> Auditoria ordenes de venta </a>
                                    @endcan
                                    @can('aplicativos_externos.cierre_ov')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/cierreov" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-times fa-3x"></i><br> Cierre ordenes de venta </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Informes
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    @can('informes_externos.pend_galvano_externo')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/galvano_v1/pendientesengalvanoexterno.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-clipboard-check fa-3x"></i><br> Pendientes en galvano externo </a>
                                    @endcan
                                    @can('informes_externos.ordenes_venta_pendientes')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/pendientesxvendedorfull.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-clipboard-list fa-3x"></i><br> Ordenes de venta pendientes </a>
                                    @endcan
                                    @can('informes_externos.descargar_ordenes_venta')
                                        <a href="http://192.168.1.54:81/intranet_ci/reportes_ventas/pendientes_x_vendedores_a_excel" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-download fa-3x"></i><br> Descargar ordenes de venta </a>
                                    @endcan
                                    @can('informes_externos.ordenes_de_venta')
                                        <a href="http://192.168.1.54:81/intraciev/ventas/vendedores.html" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-arrow-circle-up fa-3x"></i><br> Ordenes de venta </a>
                                    @endcan
                                    @can('informes_externos.inventarios_puntos_de_venta')
                                        <a href="http://192.168.1.53:81/intraciev/puntosventa/parametrizacioninventarios.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-boxes fa-3x"></i><br> Inventario puntos de ventas </a>
                                    @endcan
                                    @can('informes_externos.pendientes_galvanoplastia')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/galvano_v1/pendientesengalvano.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-tasks fa-3x"></i><br> Pendientes galvanoplastia </a>
                                    @endcan
                                    @can('informes_externos.pendientes_galvano2')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/galvano_v1/pendientesengalvano2.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-tasks fa-3x"></i><br> Pendientes galvano 2 </a>
                                    @endcan
                                    @can('informes_externos.pendientes_estatica')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/galvano/pendientesenestatica.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-check-double fa-3x"></i><br> Pendientes en estatica </a>
                                    @endcan
                                    @can('informes_externos.ov_despachar_genericos')
                                        <a href="http://192.168.1.54:81/intranet_ci/reportes_produccion/estado_ordenes_genericos" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-truck-moving fa-3x"></i><br> OV - Despachar genericos </a>
                                    @endcan
                                    @can('informes_externos.facturacion_por_dia_ev')
                                        <a href="http://192.168.1.53:81/intraciev/administracion/facturacionmax/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-file-invoice-dollar fa-3x"></i><br> Facturacion por dia EV </a>
                                    @endcan
                                    @can('informes_externos.gestion_inventarios')
                                        <a href="http://192.168.1.54:81/intraciev/ventas/gestioninventarios_v1/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-box fa-3x"></i><br> Inventario de productos </a>
                                    @endcan
                                    @can('informes_externos.consultar_clientes')
                                        <a href="http://192.168.1.53:81/intraciev/clientes/buscarclientes.html" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-user-check fa-3x"></i><br> Clientes/cuentas </a>
                                    @endcan
                                    @can('informes_externos.facturacion_x_cliente')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/facturacionxclientemax/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-chart-line fa-3x"></i><br> Facturas clientes/cuentas </a>
                                    @endcan
                                    @can('informes_externos.facturacion_x_vendedor_max')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/facturacionxvendedormax/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-chart-bar fa-3x"></i><br> Facturas por comercial </a>
                                    @endcan
                                    @can('informes_externos.indicadores_ventas')
                                        <a href="http://192.168.1.54:81/intraciev/ventas/indicadorventas/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-chart-area fa-3x"></i><br> Indicador muestras </a>
                                    @endcan
                                    @can('informes_externos.despachos_consulta_ov')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/despachos/consultaov.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-newspaper fa-3x"></i><br> Encabezado orden de venta </a>
                                    @endcan
                                    @can('informes_externos.comisiones_almacenppal')
                                        <a href="http://192.168.1.53:81/intraciev/administracion/comisionesalmacenppal/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-warehouse fa-3x"></i><br> Comisiones almacen principal </a>
                                    @endcan
                                    @can('informes_externos.facturacion_dms')
                                        <a href="http://192.168.1.53:81/intraciev/administracion/facturaciondms/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-file-invoice fa-3x"></i><br> Facturacion DMS </a>
                                    @endcan
                                    @can('informes_externos.control_entrega_galvano_calidad')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/controlentregasgalvanocalidad.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-parachute-box fa-3x"></i><br> Control entregas Galvano - Calidad </a>
                                    @endcan
                                    @can('informes_externos.control_entrega_pulido')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/controlentregaspulido.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-truck-loading fa-3x"></i><br> Control entregas Pulido </a>
                                    @endcan
                                    @can('informes_externos.control_entrega_gravolaser')
                                        <a href="http://192.168.1.53:81/intraciev/reportes/produccion/controlentregasgrabolaser.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-signature fa-3x"></i><br> Control entregas Grabolaser </a>
                                    @endcan
                                    @can('informes_externos.reimpresion_facturas')
                                        <a href="http://192.168.1.53:81/intraciev/reimpresionfacturas/" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-print fa-3x"></i><br> Visualizacion de facturas </a>
                                    @endcan
                                    @can('informes_externos.cartera_vencida')
                                        <a href="http://192.168.1.53:81/intraciev/administracion/carteravencida/index.php" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-book-reader fa-3x"></i><br> Cartera vencida </a>
                                    @endcan
                                    @can('informes_externos.consulta_ordenes_max')
                                        <a href="http://192.168.1.5/ev-piu/consultas" target="_blank" class="btn btn-primary" style="height: 100px; width: 145px"> <i class="fas fa-search-dollar fa-3x"></i><br> Consulta ordenes MAX </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan

    <style>
        .btn-primary {
            margin-bottom: 10px;
            margin-left: 8px;
        }
    </style>

@endsection












