@extends('layouts.architectui')

@section('page_title','Configuracion')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'facturacion_electronica_configuracion' ]) !!}
@stop

@section('content')
    @can('aplicaciones.facturacion_electronica.configuracion.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-tools icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Configuracion
                        <div class="page-title-subheading">
                            Configuracion para la aplicacion de facturacion electronica.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Facturas
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">ID Numeracion:</span>
                                    </div>
                                    <input type="number" class="form-control" name="fac_idnumeracion" id="fac_idnumeracion" value="{{ $data->fac_idnumeracion }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="fac_idambiente">Ambiente</span>
                                    </div>
                                    <select name="fac_idambiente" id="fac_idambiente" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <option value="1" {{ $data->fac_idambiente == 1 ? 'selected' : '' }}>Producciòn</option>
                                        <option value="2" {{ $data->fac_idambiente == 2 ? 'selected' : '' }} >Pruebas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ID Reporte</span>
                                    </div>
                                    <input type="number" class="form-control" name="fac_idreporte" id="fac_idreporte" value="{{$data->fac_idreporte}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-lg" id="SaveFacturas">Guardar Cambios</button>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Facturas exportacion
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="id_numeracion">ID Numeracion:</span>
                                    </div>
                                    <input type="number" class="form-control" name="fac_ext_idnumeracion" id="fac_ext_idnumeracion" value="{{ $data->fac_exp_id_numeracion }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Ambiente</span>
                                    </div>
                                    <select name="fac_ext_idambiente" id="fac_ext_idambiente" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <option value="1" {{ $data->fac_exp_id_ambiente == 1 ? 'selected' : '' }}>Producciòn</option>
                                        <option value="2" {{ $data->fac_exp_id_ambiente == 2 ? 'selected' : '' }} >Pruebas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ID Reporte</span>
                                    </div>
                                    <input type="number" class="form-control" name="fac_ext_idreporte" id="fac_ext_idreporte" value="{{ $data->fac_exp_id_reporte }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-lg" id="guardar_fac_exp">Guardar Cambios</button>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Notas credito
                    </div>
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="id_numeracion">ID Numeracion:</span>
                                    </div>
                                    <input type="number" class="form-control" name="nc_idnumeracion" id="nc_idnumeracion" value="{{ $data->nc_idnumeracion}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="nc_idambiente">Ambiente</span>
                                    </div>
                                    <select name="nc_idambiente" id="nc_idambiente" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <option value="1" {{ $data->nc_idambiente == 1 ? 'selected' : '' }}>Producciòn</option>
                                        <option value="2" {{ $data->nc_idambiente == 2 ? 'selected' : '' }}>Pruebas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ID Reporte</span>
                                    </div>
                                    <input type="number" class="form-control" name="nc_idreporte" id="nc_idreporte" value="{{ $data->nc_idreporte }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-lg" id="SaveNC">Guardar Cambios</button>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Notas credito exportacion
                    </div>
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">ID Numeracion:</span>
                                    </div>
                                    <input type="number" class="form-control" name="nc_ext_idnumeracion" id="nc_ext_idnumeracion" value="{{ $data->nc_exp_id_numeracion}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="nc_ext_idambiente">Ambiente</span>
                                    </div>
                                    <select name="nc_ext_idambiente" id="nc_ext_idambiente" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <option value="1" {{ $data->nc_exp_id_ambiente == 1 ? 'selected' : '' }}>Producciòn</option>
                                        <option value="2" {{ $data->nc_exp_id_ambiente == 2 ? 'selected' : '' }}>Pruebas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ID Reporte</span>
                                    </div>
                                    <input type="number" class="form-control" name="nc_ext_idreporte" id="nc_ext_idreporte" value="{{ $data->nc_exp_id_reporte }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-lg" id="guardar_nc_exp">Guardar Cambios</button>
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
@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/facturacion_electronica/configuracion/index.js') }}"></script>
@endpush
