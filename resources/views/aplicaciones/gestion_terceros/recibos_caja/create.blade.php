@extends('layouts.architectui')

@section('page_title','Nuevo RC')

@section('content')
    @can('recibos_caja.nuevo')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-credit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Recibos de caja
                        <div class="page-title-subheading">
                            Creacion de recibos de caja
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row justify-content-center">
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-5 col-5">
                                    <input type="text" class="form-control" id="cliente" name="cliente" placeholder="ingrese el nit o el nombre del cliente..." onClick="this.select();">
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-5 col-5">
                                    <button class="btn btn-primary btn-block btn-lg" disabled id="consultar" name="consultar">CONSULTAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body" id="recibos_de_caja_list">
                        <div class="alert alert-primary text-center" role="alert">
                            Por favor, consulta un cliente para ver los recibos de caja
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
@endsection

@section('modal')
    <div class="modal fade" id="calcular_desc_modal" tabindex="-1" role="dialog" aria-labelledby="calcular_desc_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">%</span>
                        </div>
                        <input type="number" class="form-control" min="0" max="100" value="0" id="descuento_input_modal" autofocus>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-primary calcular_descuento" id="0">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="info_documento_modal" tabindex="-1" role="dialog" aria-labelledby="info_documento_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="info_documento_modal_title"></h5>
                    <button type="button" class="close reset" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="info_documento_modal_table_body">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary reset" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/recibos_caja/create.js') }}"></script>
@endpush


