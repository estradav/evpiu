@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite validar las Facturas generadas en MAX.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop

@section('content')
    @can('facturacion.view')
    <div class="col-12">
        <h3> Por favor, seleccione un rango de fechas para comenzar con la busqueda <br> o seleccione una o varias facturas para generar un archivo XML.</h3>
    </div>
    <br>
    <div class="form-group">
        <div class="input-group">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Fecha inicial" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Fecha final" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary btn-sm">Buscar</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-lg-4">
        <div class="form-group">
            <span><input type="button" class="btn btn-primary btn-sm" id="CrearXml" value="Crear XML"></span>
            <span><input type="button" class="btn btn-primary btn-sm" id="WebService" value="Enviar via WebService"></span>
        </div>
    </div>
    <div class="test" id="test" name="test">

    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped" id="tfac">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" name="selectAll" class="selectAll"></th>
                                    <th>&nbsp; &nbsp;</th>
                                    <th>Numero</th>
                                    <th>OV</th>
                                    <th>Fecha</th>
                                    <th>Plazo</th>
                                    <th>Razon Social</th>
                                    <th>Tipo Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Valor bruto</th>
                                    <th>Descuento</th>
                                    <th>IVA</th>
                                    <th>Motivo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <input class="test" type="hidden" id="test" name="test" style="display: none">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar las Facturas.
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
    </style>

@push('javascript')
    <script type="text/javascript" src="/JsGlobal/FE/index.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
@endpush
@stop
