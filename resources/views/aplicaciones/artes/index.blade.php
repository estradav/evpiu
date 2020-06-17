@extends('layouts.architectui')

@section('page_title', 'Artes')

@section('content')
    @can('aplicaciones.artes.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-pen icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Artes
                        <div class="page-title-subheading">
                            Listado de artes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dataTable" id="table">
                                <thead>
                                    <tr>
                                        <th>Requerimiento</th>
                                        <th>Arte</th>
                                        <th>Producto</th>
                                        <th>Material</th>
                                        <th>Marca</th>
                                        <th>Vendedor</th>
                                        <th>Diseñador</th>
                                        <th>Solicitud</th>
                                        <th>Creacion</th>
                                        <th style="display: none !important;"></th>
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
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan

    @push('javascript')
        <script type="text/javascript" src="{{ asset('aplicaciones/artes/index.js') }}"> </script>
    @endpush
@stop
@section('modal')
    <div class="modal fade bd-example-modal-lg" id="ViewArtModal" tabindex="-1" role="dialog" aria-labelledby="ViewArtModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewArtTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="ViewArtPdf" name="ViewArtPdf" style="height:750px !important;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary btn-lg" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
