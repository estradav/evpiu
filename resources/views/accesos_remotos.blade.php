@extends('layouts.architectui')

@section('page_title', 'Accesos remotos')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'accesos_remotos' ]) !!}
@endsection

@section('content')
    @can('home.accesos_remotos.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-link icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Accesos remotos
                        <div class="page-title-subheading">
                            Acceso a aplicaciones e informes externos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Aplicaciones
                    </div>
                    <div class="card-body">
                        <div class="row mr-1 ml-1 mt-1 mb-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="btn-group special" role="group">
                                    <a href="http://192.168.1.44" class="btn btn-outline-light" target="_blank">
                                        <i class="pe-7s-next-2 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                        <b class="icon-gradient bg-premium-dark">EVPIU 2.0</b>
                                    </a>
                                
                                    @can('aplicativos_externos.gestionar_clientes_max')
                                        <a href="http://192.168.1.53:81/intraciev/cartera/index.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-users pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">GESTIONAR CLIENTES MAX</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.ev_tickets')
                                        <a href="http://192.168.1.5/ev-tickets/" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-help1 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">TICKETS</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.mantenimiento')
                                        <a href="http://192.168.1.65/auth/login" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-tools pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">MANTENIMIENTO</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.creacion_articulos')
                                        <a href="http://192.168.1.5/intranetev/index.php/aplicaciones-informaticas/creacion-de-articulos" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-box1 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">CREACION ARTICULOS</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.reque_2d_3d')
                                        <a href="http://192.168.1.12" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-box2 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">REQUERIMIENTOS 2D - 3D</b>
                                        </a>
                                    @endcan
                                </div>
                                <div class="btn-group special" role="group">
                                    @can('aplicativos_externos.admin_diseños_2d')
                                        <a href="http://192.168.1.54:81/intraciev/artes/listaartes.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-paint-bucket pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">ADMINISTRAR DISEÑOS 2D</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.tranferencia_inventarios')
                                        <a href="http://192.168.1.53:81/intraciev/puntosventa/parametrizacion.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-way pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">TRANSFERENCIA INVENTARIOS</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.glpi')
                                        <a href="http://glpi.ciev.local" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-call pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">GESTION TI</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.admin_gestion_facturacion')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-copy-file pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">TRANSFERENCIA DE FACTURACION</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.pedidos_ev')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/ordenes/index.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-date pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">PEDIDOS EV</b>
                                        </a>
                                    @endcan
                                </div>
                                <div class="btn-group special" role="group">
                                    @can('aplicativos_externos.ensamble_externo')
                                        <a href="http://192.168.1.53:81/intraciev/ensambladores/index.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-plugin pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">ENSAMBLE EXTERNO</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.etiquetas')
                                        <a href="http://192.168.1.5/ev-piu/Etiquetas" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-ticket pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">ETIQUETADO</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.admin_estruc_product')
                                        <a href="http://192.168.1.53:81/intraciev/produccion/estructuras/" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-share pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">ESTRUCTURA DE PRODUCTO</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.remisiones_ev')
                                        <a href="http://192.168.1.53:81/intraciev/ventas/remisiones/index.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-notebook pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">REMISIONES</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.remisiones_puntos_venta')
                                        <a href="http://192.168.1.53:81/intraciev/puntosventa/remisiones/index.php" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-cart pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">REMISIONES PUNTOS DE VENTA</b>
                                        </a>
                                    @endcan
                                </div>
                                <div class="btn-group special" role="group">
                                    @can('aplicativos_externos.control_salida_equipos')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/salidaequipos/" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-network pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">CONTROL DE SALIDA EQUIPOS TI</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.auditoria_ev')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/auditoriaov/" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-note2 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">AUDITORIA ORDENES DE VENTA</b>
                                        </a>
                                    @endcan
                                    @can('aplicativos_externos.cierre_ov')
                                        <a href="http://192.168.1.53:81/intraciev/sistemas/cierreov" class="btn btn-outline-light" target="_blank">
                                            <i class="pe-7s-close-circle pe-4x icon-gradient bg-premium-dark"></i> <br>
                                            <b class="icon-gradient bg-premium-dark">CIERRE ORDENES DE VENTA</b>
                                        </a>
                                    @endcan
                                    <a href="http://glpi.ciev.local/marketplace/formcreator/front/formdisplay.php?id=4" class="btn btn-outline-light" target="_blank">
                                        <i class="pe-7s-user pe-4x icon-gradient bg-premium-dark"></i> <br>
                                        <b class="icon-gradient bg-premium-dark">SALIDA / INGRESO PERSONAL</b>
                                    </a>
                                    <a href="http://192.168.1.42:510/Isolucion/PaginaLogin.aspx" class="btn btn-outline-light" target="_blank">
                                        <i class="pe-7s-next-2 pe-4x icon-gradient bg-premium-dark"></i> <br>
                                        <b class="icon-gradient bg-premium-dark">SGC</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
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
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan

    @push('styles')
        <style>
            .btn-primary {
                margin-bottom: 10px;
                margin-left: 8px;
            }

            .btn-group.special {
                display: flex;
            }

            .special .btn {
                flex: 1;
                border-radius: 0;
            }

        </style>
    @endpush

@endsection












