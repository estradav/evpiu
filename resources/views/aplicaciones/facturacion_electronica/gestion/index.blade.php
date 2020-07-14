@extends('layouts.architectui')

@section('page_title','Gestion')

@section('content')
    @can('aplicaciones.facturacion_electronica.gestion.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-diamond icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Gestion de facturacion electronica
                        <div class="page-title-subheading">
                            Gestion y auditoria de documentos subidos al WebService de fenalco.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" name="from_date" id="date" class="form-control" placeholder="Fecha inicial" />
                            <input type="number" name="fe_start" id="fe_start" class="form-control" placeholder="Factura Inicia"/>
                            <input type="number" name="fe_end" id="fe_end" class="form-control" placeholder="Factura Final"/>
                            <select name="type_doc" id="type_doc" class="form-control">
                                <option value="1">Factura</option>
                                <option value="2">Nota Debito</option>
                                <option value="3">Nota Credito</option>
                            </select>
                            <div class="btn-group input-group-append">
                                <button class="btn btn-primary" id="filter">
                                    <i class="fas fa-search"></i>
                                    Filtrar
                                </button>
                                <button class="btn btn-primary" id="Auditar">
                                    <i class="fas fa-file-invoice"></i>
                                    <i class="fas fa-check-double"></i>
                                    Auditar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>ID FACTIBLE</th>
                                        <th>FACTURA/NOTA</th>
                                        <th>TIPO</th>
                                        <th>CLIENTE</th>
                                        <th>NIT/CC</th>
                                        <th>F. GENERACION</th>
                                        <th>F. REGISTRO</th>
                                        <th>ESTADO DIAN</th>
                                        <th>ESTADO CLIENTE</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="Errors" id="Errors" style="display: none !important;"></div>

        <div id="erros_sweet" style="display: none !important;"></div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
    @push('javascript')
        <script src="{{ asset('aplicaciones/facturacion_electronica/gestion/index.js') }}"></script>
    @endpush
@endsection

@push('styles')
    <style>
        .red {
            background-color: red !important;
        }

        .preloader {
            width: 140px;
            height: 140px;
            border: 20px solid #eee;
            border-top: 20px solid #008000;
            border-radius: 50%;
            animation-name: girar;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        @keyframes girar {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .preloader_datatable {
            width: 35px;
            height: 35px;
            border: 7px solid #eee;
            border-top: 7px solid #008000;
            border-radius: 50%;
            animation-name: girar;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        th.hide_me, td.hide_me {
            display: none;
        }
    </style>
@endpush

@section('modal')
    <div class="modal fade bd-example-modal-xl" id="InfoWsInvoice" tabindex="-1" role="dialog" aria-labelledby="InfoWsInvoice" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InfoWsInvoiceTitle">Detalles Factura #</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Cliente:</b></label>
                                    <label id="nombreAdquiriente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Nit/CC:</b> </label>
                                    <label id="identificacionAdquiriente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Correo envio:</b></label>
                                    <label id="correoenvio"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Fecha Generacion:</b></label>
                                    <label id="fechageneracion"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Fecha Registro:</b></label>
                                    <label id="fecharegistro"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Estado DIAN:</b></label>
                                    <label id="descestadoenviodian"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Observacion:</b></label>
                                    <label id="processedmessage"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Estado Cliente:</b></label>
                                    <label id="descestadoenviocliente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Observacion:</b></label>
                                    <label id="comentarioenvio">Mensaje almacenado, pronto sera enviado.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12" id="correosCopia">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12" id="verificacionfuncionales">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="InfoWsObserv" tabindex="-1" role="dialog" aria-labelledby="InfoWsObserv" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InfoWsObservTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="InfoWsObservDetail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="facturas_pendientes_modal" tabindex="-1" role="dialog" aria-labelledby="facturas_pendientes_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Facturas pedientes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="facturas_pendientes_body">
                    <div class="row justify-content-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" id="subir_ws_modal">Subir WebService</button>
                            <button class="btn btn-primary" id="crear_xml_modal">Descargar XML</button>
                        </div>
                    </div>
                    <br>
                    <div class="table-resposive">
                        <table class="table table-bordered table-sm text-center" id="facturas_pendientes_table">
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" id="select_all"></th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="facturas_pendientes_table_body">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
