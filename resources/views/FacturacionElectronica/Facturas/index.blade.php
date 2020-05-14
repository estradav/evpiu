@extends('layouts.architectui')

@section('page_title', 'Facturacion electronica')

@section('content')
    @can('facturacion.view')
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Fecha inicial" id="date_time">
                                <div class="input-group-append">
                                    <button type="button" name="filter" id="filter" class="btn btn-primary btn-lx btn-block">BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="btn-group" role="group" aria-label="Basic example" style="height: 38px">
                                <button type="button" class="btn btn-primary btn-lx" id="CrearXml"><span class="fas fa-download"></span> Descargar XML</button>
                                <button type="button" class="btn btn-primary btn-lx" id="WebService"><span class="fas fa-upload"></span>  Subir via WebService</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped" id="tfac">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll" name="selectAll" class="custom-checkbox"></th>
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
    <script> let Username = @json( Auth::user()->username); </script>
    <script type="text/javascript" src="/JsGlobal/FE/index.js" ></script>
@endpush
@stop
