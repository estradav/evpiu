@extends('layouts.architectui')

@section('page_title', 'Facturacion electronica')

@section('module_title', 'Facturacion electronica')

@section('subtitle', 'Este módulo permite validar las Facturas generadas en MAX.')

@section('content')
    @can('facturacion.view')
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Fecha inicial" readonly />
                            </div>
                            <div class="col-2">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Fecha final" readonly />
                            </div>
                            <div class="col-2">
                                <button type="button" name="filter" id="filter" class="btn btn-primary btn-sm btn-block" style="height: 36px;">Buscar</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" id="CrearXml" style="height: 36px; margin-right: 25px">Descargar XML</button>
                                <button type="button" class="btn btn-primary btn-sm" id="WebService" style="height: 36px;">Subir via WebService</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped" id="tfac">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" name="selectAll" class="selectAll"></th>
                                    <th>&nbsp; &nbsp;</th>
                                    <th>NUMERO</th>
                                    <th>OV</th>
                                    <th>FECHA</th>
                                    <th>PLAZO</th>
                                    <th>RAZON SOCIAL</th>
                                    <th>NIT</th>
                                    <th>VENDEDOR</th>
                                    <th>BRUTO</th>
                                    <th>DESCUENTO</th>
                                    <th>IVA</th>
                                    <th>MOTIVO</th>
                                    <th>ESTADO DIAN</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <input class="test" type="hidden" id="test" name="test" style="display: none">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <div class="modal fade modal-sensory" id="Modal" tabindex="-1" role="dialog" aria-labelledby="modalsensory" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titleModal"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="bodyModal">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div role="dialog" tabindex="-1" class="modal fade bd-example-modal-xl" style="margin: -10px;" id="InfoWsInvoice">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-left">
                            <h4 class="modal-title">Informacion de Factura #</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body"><label style="font-size: 20px;"></label>
                            <div class="row" style="margin-right: 1% !important; margin-left: 1% !important;">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Estado envio Cliente</h4>
                                            <h6 class="text-muted card-subtitle mb-2">Informacion sobre el estado de envio al cliente</h6><label>Estado:</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body" id="testionwsda">
                                            <h4 class="card-title">Estado envio Cliente</h4>
                                            <h6 class="text-muted card-subtitle mb-2">Informacion sobre el estado de envio al cliente</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Errors" id="Errors" style="display: none !important;">

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
        .red {
            background-color: red !important;
        }

        td.details-control {
            background: url('/img/informacion.png') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('/img/x.png') no-repeat center center;
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
    </style>

@push('javascript')
    <script>
			var Username = @json( Auth::user()->username);
    </script>
    <script type="text/javascript" src="/JsGlobal/FE/index.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
{{--    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
{{--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" ></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endpush
@stop
