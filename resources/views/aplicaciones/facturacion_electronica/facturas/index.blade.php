@extends('layouts.architectui')

@section('page_title','Facturas')

@section('content')
    @can('aplicaciones.facturacion_electronica.facturas.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-cash icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Facturas
                        <div class="page-title-subheading">
                            Edicion, validacion y envio de facturas al Webservice de fenalco.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Fecha inicial" id="date_time">
                                    <div class="input-group-append">
                                        <button type="button" name="filter" id="filter" class="btn btn-primary btn-lg">Buscar</button>
                                        <button type="button" class="btn btn-primary btn-lg" id="CrearXml">Descargar XML</button>
                                        <button type="button" class="btn btn-primary btn-lg" id="WebService">Subir via WebService</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tfac" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" name="selectAll" class="custom-checkbox"></th>
                                        <th>#</th>
                                        <th>Ov</th>
                                        <th>Fecha</th>
                                        <th>Plazo</th>
                                        <th>Razon social</th>
                                        <th>NIT</th>
                                        <th>vendedor</th>
                                        <th>Bruto</th>
                                        <th>Descuento</th>
                                        <th>IVA</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
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
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
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

@push('javascript')
    <script> let Username = @json( Auth::user()->username); </script>
    <script type="text/javascript" src="{{ asset('aplicaciones/facturacion_electronica/facturas/index.js') }}"></script>
@endpush
