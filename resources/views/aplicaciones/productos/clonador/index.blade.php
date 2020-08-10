@extends('layouts.architectui')

@section('page_title', 'Clonador / Creador')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'productos_clonador' ]) !!}
@stop

@section('content')
    @can('aplicaciones.productos.clonador.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-repeat icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Clonador - Creador
                        <div class="page-title-subheading">
                            Clonador / Creador de productos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="col-6">
                            <div class="text-left">
                                @can('aplicaciones.productos.clonador.nuevo')
                                    <a class="btn btn-primary" href="javascript:void(0)" id="clonar_producto">Crear / Clonar</a>
                                @endcan
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                @can('aplicaciones.productos.codificador.nuevo')
                                    <a class="btn btn-primary" href="javascript:void(0)" id="nuevo_codigo">Codificador</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>NUMERO</th>
                                        <th>DESCRIPCION</th>
                                        <th>CREADO</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>MODIFICADO POR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->desc }}</td>
                                            <td>{{ $row->Creado }}</td>
                                            <td>{{ $row->update }}</td>
                                            <td>{{ $row->Creado }}</td>
                                        </tr>
                                    @endforeach
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
@endsection

@section('modal')
    @include('aplicaciones.productos.codificador.modal')
    @include('aplicaciones.productos.clonador.modal')
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/clonador/index.js') }}"></script>
@endpush
